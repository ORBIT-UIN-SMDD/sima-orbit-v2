<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Faculty;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class FacultyController extends Controller
{
	public function index()
	{
		$data = [
			'title' => 'List Fakultas',
			'breadcrumbs' => [
				[
					'name' => 'Dashboard',
					'link' => route('back.dashboard.index')
				],
				[
					'name' => 'Master Data',
				],
				[
					'name' => 'Fakultas',
					'link' => route('back.master.faculty.index')
				]
			],
			'faculties' => Faculty::all()
		];

		return view('back.pages.master.faculty.index', $data);
	}

	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255|unique:faculties,name',
		],[
			'name.required' => 'Nama Fakultas wajib diisi.',
			'name.unique' => 'Nama Fakultas sudah terdaftar.',
		]);

		if ($validator->fails()) {
			Alert::error('Gagal', $validator->errors()->all());
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$faculty = new Faculty();
		$faculty->name = $request->input('name');
		$faculty->save();

		return redirect()->route('back.master.faculty.index')->with('success', 'Fakultas berhasil ditambahkan.');
	}

	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255|unique:faculties,name,' . $id,
		],[
			'name.required' => 'Nama Fakultas wajib diisi.',
			'name.unique' => 'Nama Fakultas sudah terdaftar.',
		]);

		if ($validator->fails()) {
			Alert::error('Gagal', $validator->errors()->all());
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$faculty = Faculty::findOrFail($id);
		$faculty->name = $request->input('name');
		$faculty->save();

		return redirect()->route('back.master.faculty.index')->with('success', 'Fakultas berhasil diperbarui.');
	}

	public function destroy($id)
	{
		$faculty = Faculty::findOrFail($id);
		$faculty->delete();
		return redirect()->route('back.master.faculty.index')->with('success', 'Fakultas berhasil dihapus.');
	}
}
