<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DepartmentController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'List Departemen',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Departemen',
                    'link' => route('back.master.department.index')
                ]
            ],
            'departments' => Department::with('faculty')->get(),
            'faculties' => Faculty::all(),
        ];
        return view('back.pages.master.department.index', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name',
            'faculty_id' => 'required|exists:faculties,id',
        ],[
            'name.required' => 'Nama Departemen wajib diisi.',
            'name.unique' => 'Nama Departemen sudah terdaftar.',
            'faculty_id.required' => 'Fakultas wajib dipilih.',
            'faculty_id.exists' => 'Fakultas tidak valid.',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department = new Department();
        $department->name = $request->input('name');
        $department->faculty_id = $request->input('faculty_id');
        $department->save();

        return redirect()->route('back.master.department.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'faculty_id' => 'required|exists:faculties,id',
        ],[
            'name.required' => 'Nama Departemen wajib diisi.',
            'name.unique' => 'Nama Departemen sudah terdaftar.',
            'faculty_id.required' => 'Fakultas wajib dipilih.',
            'faculty_id.exists' => 'Fakultas tidak valid.',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department = Department::findOrFail($id);
        $department->name = $request->input('name');
        $department->faculty_id = $request->input('faculty_id');
        $department->save();

        return redirect()->route('back.master.department.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('back.master.department.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
