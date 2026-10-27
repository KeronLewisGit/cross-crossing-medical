<?php

if (! function_exists('ccmc')) {
    function ccmc(string $key, mixed $default = null): mixed
    {
        return config('ccmc.'.$key, $default);
    }
}

if (! function_exists('nanp_digits')) {
    /** E.164 digits for a North American (+1, incl. Trinidad and Tobago 868) number written any common way, or null. */
    function nanp_digits(?string $number): ?string
    {
        $digits = preg_replace('/\D+/', '', (string) $number) ?? '';
        if (strlen($digits) === 7) {
            $digits = '1868'.$digits; // a local T&T number written without the area code
        } elseif (strlen($digits) === 10) {
            $digits = '1'.$digits;
        }

        return strlen($digits) === 11 && $digits[0] === '1' ? $digits : null;
    }
}

if (! function_exists('tel_href')) {
    function tel_href(?string $number): string
    {
        $digits = nanp_digits($number);

        return $digits ? 'tel:+'.$digits : 'tel:'.preg_replace('/[^\d+]/', '', (string) $number);
    }
}

if (! function_exists('format_phone')) {
    /** (868) 652-4411, as the centre writes it, for +1 numbers; the input unchanged otherwise. */
    function format_phone(?string $number): string
    {
        $digits = nanp_digits($number);
        if (! $digits) {
            return (string) $number;
        }

        return sprintf('(%s) %s-%s', substr($digits, 1, 3), substr($digits, 4, 3), substr($digits, 7));
    }
}

if (! function_exists('main_phone')) {
    function main_phone(): string
    {
        return (string) (ccmc('phones')[0] ?? '');
    }
}

if (! function_exists('input_string')) {
    /** A request value as a string. Arrays (?type[]=x) and other junk become ''. */
    function input_string(mixed $value): string
    {
        return is_scalar($value) ? trim((string) $value) : '';
    }
}

if (! function_exists('old_text')) {
    /** Old input for a text box. An array posted where a string belongs (name[]=x) comes back as '', not a crash. */
    function old_text(string $key, mixed $default = null): string
    {
        $value = old($key, $default);

        return is_scalar($value) ? (string) $value : '';
    }
}

if (! function_exists('lines_to_array')) {
    /**
     * Textarea with one item per line, bullets optional, to a clean list.
     *
     * @return list<string>
     */
    function lines_to_array(?string $text): array
    {
        $lines = preg_split('/\r\n|\r|\n/', (string) $text) ?: [];
        $clean = array_map(fn (string $l) => trim((string) preg_replace('/^(?:[-*]|•)\s*/u', '', $l)), $lines);

        return array_values(array_filter($clean, fn (string $l) => $l !== ''));
    }
}

if (! function_exists('compact_number')) {
    /** 1,284 → 1.3K, used on stat tiles. */
    function compact_number(int|float $n): string
    {
        return match (true) {
            abs($n) >= 1_000_000 => round($n / 1_000_000, 1).'M',
            abs($n) >= 10_000 => round($n / 1_000).'K',
            default => number_format($n),
        };
    }
}

if (! function_exists('photo')) {
    /**
     * Responsive <img> attributes for a photo in public/img. Each photo is written at 480, 960
     * and 1920 wide, but never wider than its source, so small originals are not blown up:
     * the srcset only lists the widths that exist.
     *
     * @return array{src: string, srcset: string, width: int, height: int}
     */
    function photo(string $key): array
    {
        $meta = config('ccmc.photos.'.$key) ?? ['w' => 960, 'h' => 640, 'sizes' => [480, 960]];
        $sizes = $meta['sizes'] ?? [480, 960, 1920];
        $url = fn (int $w) => asset("img/{$key}-{$w}.webp");

        return [
            'src' => $url(in_array(960, $sizes, true) ? 960 : (int) end($sizes)),
            'srcset' => implode(', ', array_map(fn (int $w) => $url($w).' '.min($w, (int) $meta['w']).'w', $sizes)),
            'width' => (int) $meta['w'],
            'height' => (int) $meta['h'],
        ];
    }
}

if (! function_exists('wa_href')) {
    /** WhatsApp click-to-chat link for staff replying to a patient, optionally with a prefilled message. */
    function wa_href(?string $number, ?string $text = null): string
    {
        $digits = nanp_digits($number) ?? preg_replace('/\D+/', '', (string) $number);

        return 'https://wa.me/'.$digits.($text ? '?text='.rawurlencode($text) : '');
    }
}
