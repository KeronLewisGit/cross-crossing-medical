<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings', ['notice' => Setting::get('public_notice')]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'public_notice' => ['nullable', 'string', 'max:280'],
        ], [], ['public_notice' => 'public notice']);

        Setting::put('public_notice', isset($data['public_notice']) ? trim($data['public_notice']) : null);

        return back()->with('status', 'Settings saved.');
    }
}
