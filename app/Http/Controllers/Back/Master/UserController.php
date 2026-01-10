<?php

namespace App\Http\Controllers\Back\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
                    'name' => 'Pengguna',
                    'link' => route('back.master.user.index')
                ]
            ],
            'users' => User::with('department')->get()
        ];

        return view('back.pages.master.user.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Pengguna',
                    'link' => route('back.master.user.index')
                ],
                [
                    'name' => 'Tambah Pengguna',
                    'link' => route('back.master.user.create')
                ]
            ],
            'departments' => Department::all()
        ];

        return view('back.pages.master.user.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nim' => 'nullable|unique:users,nim',
            'name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'phone' => 'nullable|string|max:20',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'department_id' => 'nullable|exists:departments,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'is_active' => 'nullable|boolean',
        ], [
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berformat jpg, jpeg, png',
            'photo.max' => 'Ukuran foto maksimal 2MB',
            'nim.unique' => 'NIM sudah digunakan',
            'name.required' => 'Nama harus diisi',
            'gender.in' => 'Jenis kelamin harus laki-laki atau perempuan',
            'blood_type.in' => 'Golongan darah harus A, B, AB, atau O',
            'department_id.exists' => 'Departemen tidak valid',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->nim = $request->nim;
        $user->name = $request->name;
        $user->place_of_birth = $request->place_of_birth;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->job = $request->job;
        $user->address = $request->address;
        $user->bio = $request->bio;
        $user->blood_type = $request->blood_type;
        $user->department_id = $request->department_id;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->is_active = $request->has('is_active') ? true : false;

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = Str::slug($request->name) . "-" . time() . "." . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('uploads/user/photo', $photoName, 'public');
            $user->photo = $photoPath;
        }
        $user->save();

        // Assign roles
        if ($request->role_admin) {
            $user->assignRole('super-admin');
        }
        if ($request->role_humas) {
            $user->assignRole('humas');
        }

        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }

        Alert::success('Berhasil', 'Data pengguna berhasil ditambahkan');
        return redirect()->route('back.master.user.index');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengguna',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Master Data',
                ],
                [
                    'name' => 'Pengguna',
                    'link' => route('back.master.user.index')
                ],
                [
                    'name' => 'Edit Pengguna',
                    'link' => route('back.master.user.edit', $id)
                ]
            ],
            'user' => User::findOrFail($id),
            'departments' => Department::all()
        ];

        return view('back.pages.master.user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nim' => 'nullable|unique:users,nim,' . $id,
            'name' => 'required|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:laki-laki,perempuan',
            'phone' => 'nullable|string|max:20',
            'job' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'bio' => 'nullable|string',
            'blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'department_id' => 'nullable|exists:departments,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'is_active' => 'nullable|boolean',
        ], [
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berformat jpg, jpeg, png',
            'photo.max' => 'Ukuran foto maksimal 2MB',
            'nim.unique' => 'NIM sudah digunakan',
            'name.required' => 'Nama harus diisi',
            'gender.in' => 'Jenis kelamin harus laki-laki atau perempuan',
            'blood_type.in' => 'Golongan darah harus A, B, AB, atau O',
            'department_id.exists' => 'Departemen tidak valid',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->nim = $request->nim;
        $user->name = $request->name;
        $user->place_of_birth = $request->place_of_birth;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->phone = $request->phone;
        $user->job = $request->job;
        $user->address = $request->address;
        $user->bio = $request->bio;
        $user->blood_type = $request->blood_type;
        $user->department_id = $request->department_id;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->email = $request->email;
        $user->is_active = $request->has('is_active') ? true : false;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $photo = $request->file('photo');
            $photoName = Str::slug($request->name) . "-" . time() . "." . $photo->getClientOriginalExtension();
            $photoPath = $photo->storeAs('uploads/user/photo', $photoName, 'public');
            $user->photo = $photoPath;
        }
        $user->save();

        // Update roles
        if ($request->role_admin) {
            $user->assignRole('super-admin');
        } else {
            $user->removeRole('super-admin');
        }

        if ($request->role_humas) {
            $user->assignRole('humas');
        } else {
            $user->removeRole('humas');
        }

        $user->permissions()->detach();
        if ($request->permissions) {
            foreach ($request->permissions as $permission) {
                $user->givePermissionTo($permission);
            }
        }

        Alert::success('Berhasil', 'Data pengguna berhasil diubah');
        return redirect()->route('back.master.user.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();

        Alert::success('Berhasil', 'Data pengguna berhasil dihapus');
        return redirect()->route('back.master.user.index');
    }
}
