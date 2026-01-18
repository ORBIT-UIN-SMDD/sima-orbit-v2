<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentUser;
use App\Models\Period;
use App\Models\PeriodUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * Display a listing of appointments for the current user
     */
    public function index(Request $request)
    {
        $periodId = $request->period_id;

        // Get appointments where current user is assigned
        $query = AppointmentUser::with(['appointment.period', 'appointment'])
            ->where('user_id', Auth::id());

        if ($periodId) {
            $query->whereHas('appointment', function ($q) use ($periodId) {
                $q->where('period_id', $periodId);
            });
        }

        $data = [
            'title' => 'Penugasan Saya',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Penugasan Saya',
                    'link' => route('back.appointment.index')
                ]
            ],
            'appointmentUsers' => $query->latest()->get(),
            'periods' => Period::orderBy('name', 'desc')->get(),
            'filter_period_id' => $periodId
        ];

        return view('back.pages.appointment.index', $data);
    }

    /**
     * Display a listing of all appointments for management (admin)
     */
    public function manage(Request $request)
    {
        $periodId = $request->period_id;

        $query = Appointment::with(['period', 'appointmentUsers.user']);

        if ($periodId) {
            $query->where('period_id', $periodId);
        }

        $data = [
            'title' => 'Manajemen Penugasan',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Manajemen Penugasan',
                    'link' => route('back.appointment.manage')
                ]
            ],
            'appointments' => $query->latest()->get(),
            'periods' => Period::orderBy('name', 'desc')->get(),
            'filter_period_id' => $periodId
        ];

        return view('back.pages.appointment.manage', $data);
    }

    /**
     * Show the form for creating a new appointment
     */
    public function create(Request $request)
    {
        $data = [
            'title' => 'Tambah Penugasan',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Manajemen Penugasan',
                    'link' => route('back.appointment.manage')
                ],
                [
                    'name' => 'Tambah Penugasan',
                    'link' => route('back.appointment.create')
                ]
            ],
            'periods' => Period::active()->orderBy('name', 'desc')->get(),
            'users' => User::orderBy('name')->get(),
            'selected_period_id' => $request->period_id
        ];

        return view('back.pages.appointment.create', $data);
    }

    /**
     * Store a newly created appointment
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'appointment_start_date' => 'required|date',
                'appointment_end_date' => 'nullable|date|after_or_equal:appointment_start_date',
                'location' => 'nullable|string|max:255',
                'organizer' => 'nullable|string|max:255',
                'number' => 'nullable|string|max:255',
                'file_sk' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'period_id' => 'required|exists:periods,id',
                'users' => 'nullable|array',
                'users.*' => 'exists:users,id',
                'divisions' => 'nullable|array',
            ],
            [
                'name.required' => 'Nama penugasan harus diisi',
                'appointment_start_date.required' => 'Tanggal mulai harus diisi',
                'appointment_end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
                'period_id.required' => 'Periode harus dipilih',
                'period_id.exists' => 'Periode tidak valid',
                'file_sk.mimes' => 'File SK harus berformat PDF, DOC, atau DOCX',
                'file_sk.max' => 'Ukuran file SK maksimal 5MB',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->all());
        }

        $appointment = new Appointment();
        $appointment->name = $request->name;
        $appointment->description = $request->description;
        $appointment->appointment_start_date = $request->appointment_start_date;
        $appointment->appointment_end_date = $request->appointment_end_date;
        $appointment->location = $request->location;
        $appointment->organizer = $request->organizer;
        $appointment->number = $request->number;
        $appointment->period_id = $request->period_id;

        if ($request->hasFile('file_sk')) {
            $file = $request->file('file_sk');
            $appointment->file_sk = $file->storeAs(
                'appointments',
                date('YmdHis') . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension(),
                'public'
            );
        }

        $appointment->save();

        // Add users to appointment
        if ($request->has('users') && is_array($request->users)) {
            foreach ($request->users as $index => $userId) {
                AppointmentUser::create([
                    'appointment_id' => $appointment->id,
                    'user_id' => $userId,
                    'division' => $request->divisions[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('back.appointment.manage', ['period_id' => $request->period_id])
            ->with('success', 'Penugasan berhasil ditambahkan');
    }

    /**
     * Display the specified appointment
     */
    public function show($id)
    {
        $appointment = Appointment::with(['period', 'appointmentUsers.user'])->findOrFail($id);

        $data = [
            'title' => 'Detail Penugasan',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Manajemen Penugasan',
                    'link' => route('back.appointment.manage')
                ],
                [
                    'name' => 'Detail Penugasan',
                    'link' => route('back.appointment.show', $id)
                ]
            ],
            'appointment' => $appointment,
            'users' => User::orderBy('name')->get()
        ];

        return view('back.pages.appointment.show', $data);
    }

    /**
     * Show the form for editing the specified appointment
     */
    public function edit($id)
    {
        $appointment = Appointment::with(['appointmentUsers', 'period'])->findOrFail($id);

        // Check if period is still active
        if (!$appointment->period->isActive()) {
            return redirect()->route('back.appointment.manage')
                ->with('error', 'Tidak dapat mengedit penugasan. Periode sudah berakhir.');
        }

        $data = [
            'title' => 'Edit Penugasan',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Manajemen Penugasan',
                    'link' => route('back.appointment.manage')
                ],
                [
                    'name' => 'Edit Penugasan',
                    'link' => route('back.appointment.edit', $id)
                ]
            ],
            'appointment' => $appointment,
            'periods' => Period::active()->orderBy('name', 'desc')->get(),
            'users' => User::orderBy('name')->get()
        ];

        return view('back.pages.appointment.edit', $data);
    }

    /**
     * Update the specified appointment
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::with('period')->findOrFail($id);

        // Check if period is still active
        if (!$appointment->period->isActive()) {
            return redirect()->route('back.appointment.manage')
                ->with('error', 'Tidak dapat mengubah penugasan. Periode sudah berakhir.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'appointment_start_date' => 'required|date',
                'appointment_end_date' => 'nullable|date|after_or_equal:appointment_start_date',
                'location' => 'nullable|string|max:255',
                'organizer' => 'nullable|string|max:255',
                'number' => 'nullable|string|max:255',
                'file_sk' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'period_id' => 'required|exists:periods,id',
            ],
            [
                'name.required' => 'Nama penugasan harus diisi',
                'appointment_start_date.required' => 'Tanggal mulai harus diisi',
                'appointment_end_date.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
                'period_id.required' => 'Periode harus dipilih',
                'period_id.exists' => 'Periode tidak valid',
                'file_sk.mimes' => 'File SK harus berformat PDF, DOC, atau DOCX',
                'file_sk.max' => 'Ukuran file SK maksimal 5MB',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->all());
        }

        $appointment->name = $request->name;
        $appointment->description = $request->description;
        $appointment->appointment_start_date = $request->appointment_start_date;
        $appointment->appointment_end_date = $request->appointment_end_date;
        $appointment->location = $request->location;
        $appointment->organizer = $request->organizer;
        $appointment->number = $request->number;
        $appointment->period_id = $request->period_id;

        if ($request->hasFile('file_sk')) {
            // Delete old file
            if ($appointment->file_sk) {
                Storage::disk('public')->delete($appointment->file_sk);
            }

            $file = $request->file('file_sk');
            $appointment->file_sk = $file->storeAs(
                'appointments',
                date('YmdHis') . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension(),
                'public'
            );
        }

        $appointment->save();

        return redirect()->route('back.appointment.manage', ['period_id' => $request->period_id])
            ->with('success', 'Penugasan berhasil diubah');
    }

    /**
     * Remove the specified appointment
     */
    public function destroy($id)
    {
        $appointment = Appointment::with('period')->findOrFail($id);
        $periodId = $appointment->period_id;

        // Check if period is still active
        if (!$appointment->period->isActive()) {
            return redirect()->route('back.appointment.manage', ['period_id' => $periodId])
                ->with('error', 'Tidak dapat menghapus penugasan. Periode sudah berakhir.');
        }

        // Delete file if exists
        if ($appointment->file_sk) {
            Storage::disk('public')->delete($appointment->file_sk);
        }

        $appointment->delete();

        return redirect()->route('back.appointment.manage', ['period_id' => $periodId])
            ->with('success', 'Penugasan berhasil dihapus');
    }

    /**
     * Add user to appointment
     */
    public function addUser(Request $request, $id)
    {
        $appointment = Appointment::with('period')->findOrFail($id);

        // Check if period is still active
        if (!$appointment->period->isActive()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menambah user. Periode sudah berakhir.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'division' => 'nullable|string|max:255',
            ],
            [
                'user_id.required' => 'User harus dipilih',
                'user_id.exists' => 'User tidak valid',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', $validator->errors()->all());
        }

        // Check if user already assigned
        $exists = AppointmentUser::where('appointment_id', $id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'User sudah terdaftar di penugasan ini');
        }

        AppointmentUser::create([
            'appointment_id' => $id,
            'user_id' => $request->user_id,
            'division' => $request->division,
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan ke penugasan');
    }

    /**
     * Update user in appointment
     */
    public function updateUser(Request $request, $id, $appointmentUserId)
    {
        $appointment = Appointment::with('period')->findOrFail($id);

        // Check if period is still active
        if (!$appointment->period->isActive()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat mengubah data user. Periode sudah berakhir.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'division' => 'nullable|string|max:255',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->with('error', $validator->errors()->all());
        }

        $appointmentUser = AppointmentUser::findOrFail($appointmentUserId);
        $appointmentUser->division = $request->division;
        $appointmentUser->save();

        return redirect()->back()->with('success', 'Data user berhasil diubah');
    }

    /**
     * Remove user from appointment
     */
    public function removeUser($id, $appointmentUserId)
    {
        $appointment = Appointment::with('period')->findOrFail($id);

        // Check if period is still active
        if (!$appointment->period->isActive()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus user. Periode sudah berakhir.');
        }

        $appointmentUser = AppointmentUser::findOrFail($appointmentUserId);
        $appointmentUser->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus dari penugasan');
    }
}
