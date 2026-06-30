<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::orderBy('key')->get();

        return view('settings.index', compact('settings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'key' => ['required', 'string', 'max:255'],
            'value' => ['nullable', 'string'],
        ]);

        Setting::updateOrCreate(['key' => $data['key']], ['value' => $data['value'] ?? null]);

        return redirect()->route('settings.index')->with('status', 'Setting saved successfully.');
    }

    public function update(Request $request, Setting $setting): RedirectResponse
    {
        $data = $request->validate([
            'value' => ['nullable', 'string'],
        ]);

        $setting->update(['value' => $data['value'] ?? null]);

        return redirect()->route('settings.index')->with('status', 'Setting updated successfully.');
    }

    public function destroy(Setting $setting): RedirectResponse
    {
        $setting->delete();

        return redirect()->route('settings.index')->with('status', 'Setting deleted successfully.');
    }
}
