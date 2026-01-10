<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'list_data' => AboutUs::orderBy('order', 'asc')->get(),
        ];

        return view('back.pages.about_us.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kata Sambutan',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Kata Sambutan',
                    'link' => route('back.about-us.index')
                ],
                [
                    'name' => 'Tambah',
                    'link' => route('back.about-us.create')
                ],
            ],
        ];

        return view('back.pages.about_us.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
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

        $imagePath = $request->file('image')->store('about_us', 'public');

        AboutUs::create([
            'name' => $request->name,
            'image' => $imagePath,
            'content' => $request->content,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect()->route('back.about-us.index');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kata Sambutan',
            'breadcrumb' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Kata Sambutan',
                    'link' => route('back.about-us.index')
                ],
                [
                    'name' => 'Edit',
                    'link' => route('back.about-us.edit', $id)
                ],
            ],
            'data' => AboutUs::findOrFail($id),
        ];

        return view('back.pages.about_us.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'image.image' => 'Gambar harus berupa gambar',
            'image.mimes' => 'Gambar harus berformat jpeg, png, jpg, gif, svg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'content.required' => 'Konten wajib diisi',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $about_us = AboutUs::findOrFail($id);

        $dataUpdate = [
            'name' => $request->name,
            'content' => $request->content,
            'order' => $request->order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if ($about_us->image && Storage::disk('public')->exists($about_us->image)) {
                Storage::disk('public')->delete($about_us->image);
            }
            $dataUpdate['image'] = $request->file('image')->store('about_us', 'public');
        }

        $about_us->update($dataUpdate);

        Alert::success('Berhasil', 'Data berhasil diupdate');
        return redirect()->route('back.about-us.index');
    }

    public function destroy($id)
    {
        $about_us = AboutUs::findOrFail($id);

        // Delete image
        if ($about_us->image && Storage::disk('public')->exists($about_us->image)) {
            Storage::disk('public')->delete($about_us->image);
        }

        $about_us->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('back.about-us.index');
    }
}
