<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Browsers always send valid UTF-8, bots do not. A stray invalid byte would make the JSON
 * session unwritable (the visitor loses the form and its errors) and MySQL refuses it with
 * "Incorrect string value", so invalid sequences are replaced before anything reads the input.
 */
class ScrubInvalidUtf8
{
    public function handle(Request $request, Closure $next): Response
    {
        foreach ([$request->query, $request->request] as $bag) {
            $all = $bag->all();
            $clean = self::scrub($all);
            if ($clean !== $all) {
                $bag->replace($clean);
            }
        }

        return $next($request);
    }

    /**
     * @param  array<mixed>  $values
     * @return array<mixed>
     */
    private static function scrub(array $values): array
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $values[$key] = self::scrub($value);
            } elseif (is_string($value) && ! mb_check_encoding($value, 'UTF-8')) {
                $values[$key] = mb_scrub($value, 'UTF-8');
            }
        }

        return $values;
    }
}
