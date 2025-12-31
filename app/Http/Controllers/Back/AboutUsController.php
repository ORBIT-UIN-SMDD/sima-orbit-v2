<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AboutUsController extends Controller
{
     public function index()
    {
        $data = [
            'title' => 'Kata Sambutan',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Kata Sambutan',
                    'link' => route('back.about-us.index')
                ],
            ],
            'data' => AboutUs::first() ?? new AboutUs(),
        ];

        return view('back.pages.about_us', $data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'image.required' => 'Gambar wajib diisi',
            'image.image' => 'Gambar harus berupa gambar',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'content.required' => 'Konten wajib diisi',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $about_us = AboutUs::first();



        if (!$about_us) {
            $about_us = new AboutUs();
        }

        if ($request->hasFile('image')) {
            $about_us->fill([
                'name' => $request->name,
                'image' => $request->file('image')->storeAs('about_us', 'about_us.' . $request->file('image')->extension(), 'public'),
                'content' => $request->content,
            ]);
        } else {
            $about_us->fill([
                'name' => $request->name,
                'content' => $request->content,
            ]);
        }

        $about_us->save();

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->route('back.aboutUs.index');
    }
}
