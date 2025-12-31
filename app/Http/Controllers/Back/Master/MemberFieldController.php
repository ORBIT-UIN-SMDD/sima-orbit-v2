<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\MemberField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class MemberFieldController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'List Pengguna',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Bidang Keanggotaan',
                    'link' => route('back.master.member-field.index')
                ]
            ],
            'memberFields' => MemberField::all()
        ];

        return view('back.pages.master.member_field.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ],[
            'name.required' => 'Nama Bidang wajib diisi.',
            'image.required' => 'Logo Bidang wajib diisi.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]
        );

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $memberField = new MemberField();
        $memberField->name = $request->input('name');
        $memberField->description = $request->input('description');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($memberField->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('member_fields', $fileName, 'public');
            $memberField->image = $imagePath;
        }

        $memberField->save();

        return redirect()->route('back.master.member-field.index')->with('success', 'Bidang Keanggotaan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ],[
            'name.required' => 'Nama Bidang wajib diisi.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]
        );

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $memberField = MemberField::findOrFail($id);
        $memberField->name = $request->input('name');
        $memberField->description = $request->input('description');

        if ($request->hasFile('image')) {
            if ($memberField->image) {
                Storage::delete('public/' . $memberField->image);
            }
            $image = $request->file('image');
            $fileName = time() . '_' . Str::slug($memberField->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('member_fields', $fileName, 'public');
            $memberField->image = $imagePath;
        }

        $memberField->save();

        return redirect()->route('back.master.member-field.index')->with('success', 'Bidang Keanggotaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $memberField = MemberField::findOrFail($id);
        if ($memberField->image) {
            Storage::delete($memberField->image);
        }
        $memberField->delete();


        return redirect()->route('back.master.member-field.index')->with('success', 'Bidang Keanggotaan berhasil dihapus.');
    }
}
