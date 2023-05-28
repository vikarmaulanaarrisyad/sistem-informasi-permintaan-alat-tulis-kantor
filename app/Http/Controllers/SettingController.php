<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        return view('setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $rules = [
            'owner_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|string|min:11|max:17',
            'phone_hours' => 'required',
            'about' => 'required',
            'address' => 'nullable',
            'city' => 'nullable',
            'province' => 'nullable',
            'company_name' => 'required',
            'short_description' => 'required',
            'keyword' => 'nullable'
        ];

        if ($request->has('pills') && $request->pills == 'logo') {
            $rules = [
                'path_image' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'path_image_header' => 'nullable|mimes:png,jpg,jpeg|max:2048',
                'path_image_footer' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ];
        }

        if ($request->has('pills') && $request->pills == 'sosial-media') {
            $rules = [
                'instagram_link' => 'required|url',
                'twitter_link' => 'required|url',
                'fanpage_link' => 'required|url',
                'google_plus_link' => 'required|url'
            ];
        }

        $data = $request->except('path_image', 'path_image_header', 'path_image_footer','pills');

        if ($request->hasFile('path_image')) {
            if (Storage::disk('public')->exists($request->path_image)) {
                Storage::disk('public')->delete($request->path_image);
            }

            $data['path_image'] = upload('setting', $request->file('path_image'), 'setting');
        }

        if ($request->hasFile('path_image_header')) {
            if (Storage::disk('public')->exists($request->path_image_header)) {
                Storage::disk('public')->delete($request->path_image_header);
            }

            $data['path_image_header'] = upload('setting', $request->file('path_image_header'), 'setting');
        }

        if ($request->hasFile('path_image_footer')) {
            if (Storage::disk('public')->exists($request->path_image_footer)) {
                Storage::disk('public')->delete($request->path_image_footer);
            }

            $data['path_image_footer'] = upload('setting', $request->file('path_image_footer'), 'setting');
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            back()->withErrors($validator->errors());
            Session::flash('error', true);
            Session::flash('message', 'Terjadi kesalahan validasi inputan');
            return;
        }

        $setting->update($data);

        Session::flash('success', true);
        Session::flash('message', 'Pengaturan berhasil disimpan.');

        return redirect()->route('setting.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
