<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    // Tampilkan setting
    public function index()
    {
        $settings = Setting::first();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'data' => $settings]);
        }

        return view('settings.index', compact('settings'));
    }

    // Update setting
    public function update(Request $request)
    {
        $validated = $request->validate([
            'discount' => 'nullable|numeric|min:0|max:100',
            'tax' => 'nullable|numeric|min:0|max:100',
            'service_charge' => 'nullable|numeric|min:0|max:100',
        ]);

        $setting = Setting::updateOrCreate(['id' => 1], $validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Setting berhasil diperbarui',
                'data' => $setting
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Setting berhasil diperbarui');
    }
}
