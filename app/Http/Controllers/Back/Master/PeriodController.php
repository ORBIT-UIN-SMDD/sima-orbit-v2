<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use App\Models\MemberField;
use App\Models\Period;
use App\Models\PeriodUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'List Periode',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Periode',
                    'link' => route('back.master.period.index')
                ]
            ],
            'periods' => Period::withCount('periodUsers')->latest()->get()
        ];

        return view('back.pages.master.period.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Periode',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Periode',
                    'link' => route('back.master.period.index')
                ],
                [
                    'name' => 'Tambah Periode',
                    'link' => route('back.master.period.create')
                ]
            ]
        ];

        return view('back.pages.master.period.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:periods,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama periode harus diisi',
            'name.unique' => 'Nama periode sudah digunakan',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Period::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        Alert::success('Berhasil', 'Periode berhasil ditambahkan');
        return redirect()->route('back.master.period.index');
    }

    public function edit($id)
    {
        $period = Period::findOrFail($id);

        $data = [
            'title' => 'Edit Periode',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Periode',
                    'link' => route('back.master.period.index')
                ],
                [
                    'name' => 'Edit Periode',
                    'link' => route('back.master.period.edit', $id)
                ]
            ],
            'period' => $period
        ];

        return view('back.pages.master.period.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:periods,name,' . $id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama periode harus diisi',
            'name.unique' => 'Nama periode sudah digunakan',
            'start_date.required' => 'Tanggal mulai harus diisi',
            'end_date.required' => 'Tanggal selesai harus diisi',
            'end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $period = Period::findOrFail($id);
        $period->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);

        Alert::success('Berhasil', 'Periode berhasil diubah');
        return redirect()->route('back.master.period.index');
    }

    public function destroy($id)
    {
        $period = Period::findOrFail($id);
        $period->delete();

        Alert::success('Berhasil', 'Periode berhasil dihapus');
        return redirect()->route('back.master.period.index');
    }

    // Detail Periode - Anggota Periode
    public function show($id)
    {
        $period = Period::with(['periodUsers.user', 'periodUsers.memberField'])->findOrFail($id);

        $data = [
            'title' => 'Detail Periode: ' . $period->name,
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Periode',
                    'link' => route('back.master.period.index')
                ],
                [
                    'name' => 'Detail Periode',
                    'link' => route('back.master.period.show', $id)
                ]
            ],
            'period' => $period,
            'periodUsers' => $period->periodUsers,
            'users' => User::whereNotIn('id', $period->periodUsers->pluck('user_id'))->get(),
            'memberFields' => MemberField::all(),
            'roles' => [
                'Ketua Umum',
                'Wakil Ketua Umum',
                'Sekretaris Umum',
                'Bendahara Umum',
                'Kepala Bidang',
                'Sekretaris Bidang',
                'Bendahara Bidang',
                'Anggota Bidang',
                'Anggota'
            ]
        ];

        return view('back.pages.master.period.show', $data);
    }

    public function addUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:Ketua Umum,Wakil Ketua Umum,Sekretaris Umum,Bendahara Umum,Kepala Bidang,Sekretaris Bidang,Bendahara Bidang,Anggota Bidang,Anggota',
            'member_field_id' => 'nullable|exists:member_fields,id',
        ], [
            'user_id.required' => 'User harus dipilih',
            'user_id.exists' => 'User tidak valid',
            'role.required' => 'Jabatan harus dipilih',
            'role.in' => 'Jabatan tidak valid',
            'member_field_id.exists' => 'Bidang tidak valid',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if user already exists in this period
        $exists = PeriodUser::where('period_id', $id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            Alert::error('Gagal', 'User sudah terdaftar dalam periode ini');
            return redirect()->back();
        }

        PeriodUser::create([
            'period_id' => $id,
            'user_id' => $request->user_id,
            'role' => $request->role,
            'member_field_id' => $request->member_field_id,
        ]);

        Alert::success('Berhasil', 'Anggota berhasil ditambahkan ke periode');
        return redirect()->route('back.master.period.show', $id);
    }

    public function updateUser(Request $request, $id, $periodUserId)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|in:Ketua Umum,Wakil Ketua Umum,Sekretaris Umum,Bendahara Umum,Kepala Bidang,Sekretaris Bidang,Bendahara Bidang,Anggota Bidang,Anggota',
            'member_field_id' => 'nullable|exists:member_fields,id',
        ], [
            'role.required' => 'Jabatan harus dipilih',
            'role.in' => 'Jabatan tidak valid',
            'member_field_id.exists' => 'Bidang tidak valid',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $periodUser = PeriodUser::findOrFail($periodUserId);
        $periodUser->update([
            'role' => $request->role,
            'member_field_id' => $request->member_field_id,
        ]);

        Alert::success('Berhasil', 'Data anggota berhasil diubah');
        return redirect()->route('back.master.period.show', $id);
    }

    public function removeUser($id, $periodUserId)
    {
        $periodUser = PeriodUser::findOrFail($periodUserId);
        $periodUser->delete();

        Alert::success('Berhasil', 'Anggota berhasil dihapus dari periode');
        return redirect()->route('back.master.period.show', $id);
    }
}
