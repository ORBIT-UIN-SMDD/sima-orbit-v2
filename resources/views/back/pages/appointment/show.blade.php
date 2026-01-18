@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="d-flex flex-column flex-lg-row">
            {{-- Main Info --}}
            <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title">
                            <h2 class="fw-bold">Detail Penugasan</h2>
                        </div>
                        @if($appointment->period && $appointment->period->isActive())
                            <div class="card-toolbar">
                                <a href="{{ route('back.appointment.edit', $appointment->id) }}" class="btn btn-sm btn-light-primary">
                                    <i class="ki-duotone ki-pencil fs-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Edit
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body pt-3">
                        <div class="mb-10">
                            <h3 class="text-gray-800 fw-bold mb-3">{{ $appointment->name }}</h3>
                            @if($appointment->number)
                                <span class="badge badge-light-primary fs-7 mb-3">No: {{ $appointment->number }}</span>
                            @endif
                        </div>

                        <div class="row mb-7">
                            <div class="col-lg-4">
                                <span class="fw-semibold text-muted d-block fs-7">Periode</span>
                                <div class="d-flex flex-column gap-1">
                                    <span class="fw-bold text-gray-800 fs-6">{{ $appointment->period->name ?? '-' }}</span>
                                    @if($appointment->period && !$appointment->period->isActive())
                                        <span class="badge badge-light-danger fs-8 w-auto">Periode Berakhir</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <span class="fw-semibold text-muted d-block fs-7">Penyelenggara</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ $appointment->organizer ?? '-' }}</span>
                            </div>
                            <div class="col-lg-4">
                                <span class="fw-semibold text-muted d-block fs-7">Lokasi</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ $appointment->location ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-lg-4">
                                <span class="fw-semibold text-muted d-block fs-7">Tanggal Mulai</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ \Carbon\Carbon::parse($appointment->appointment_start_date)->format('d F Y') }}</span>
                            </div>
                            <div class="col-lg-4">
                                <span class="fw-semibold text-muted d-block fs-7">Tanggal Selesai</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ $appointment->appointment_end_date ? \Carbon\Carbon::parse($appointment->appointment_end_date)->format('d F Y') : '-' }}</span>
                            </div>
                            <div class="col-lg-4">
                                <span class="fw-semibold text-muted d-block fs-7">File SK</span>
                                @if($appointment->file_sk)
                                    <a href="{{ Storage::url($appointment->file_sk) }}" target="_blank" class="btn btn-sm btn-light-primary">
                                        <i class="ki-duotone ki-file fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Download
                                    </a>
                                @else
                                    <span class="fw-bold text-gray-800 fs-6">-</span>
                                @endif
                            </div>
                        </div>

                        @if($appointment->description)
                            <div class="mb-0">
                                <span class="fw-semibold text-muted d-block fs-7 mb-2">Deskripsi</span>
                                <div class="fw-semibold text-gray-800 fs-6">{!! nl2br(e($appointment->description)) !!}</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Members Card --}}
                <div class="card card-flush pt-3 mb-5 mb-xl-10">
                    <div class="card-header">
                        <div class="card-title">
                            <h2 class="fw-bold">Anggota Penugasan</h2>
                        </div>
                        @if($appointment->period && $appointment->period->isActive())
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#add_user_modal">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                    Tambah Anggota
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body pt-3">
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-50px">No</th>
                                    <th class="min-w-200px">Nama</th>
                                    <th class="min-w-150px">Divisi/Jabatan</th>
                                    <th class="text-end min-w-100px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse ($appointment->appointmentUsers as $index => $au)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-circle symbol-40px overflow-hidden me-3">
                                                    <img src="{{ $au->user->getPhoto() }}" alt="{{ $au->user->name }}" />
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold">{{ $au->user->name }}</span>
                                                    <span class="text-muted fs-7">{{ $au->user->email }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $au->division ?? '-' }}</td>
                                        <td class="text-end">
                                            @if($appointment->period && $appointment->period->isActive())
                                                <button type="button" class="btn btn-sm btn-icon btn-light-primary me-1"
                                                    data-bs-toggle="modal" data-bs-target="#edit_user_{{ $au->id }}">
                                                    <i class="ki-duotone ki-pencil fs-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-icon btn-light-danger"
                                                    data-bs-toggle="modal" data-bs-target="#delete_user_{{ $au->id }}">
                                                    <i class="ki-duotone ki-trash fs-5">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                            @else
                                                <span class="text-muted fs-8">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-10">
                                            Belum ada anggota penugasan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                <div class="card card-flush mb-0">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Ringkasan</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">Total Anggota</div>
                            <div class="d-flex align-items-senter">
                                <span class="text-gray-900 fw-bolder fs-6">{{ $appointment->appointmentUsers->count() }}</span>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">Durasi</div>
                            <div class="d-flex align-items-senter">
                                @if($appointment->appointment_end_date)
                                    <span class="text-gray-900 fw-bolder fs-6">
                                        {{ \Carbon\Carbon::parse($appointment->appointment_start_date)->diffInDays(\Carbon\Carbon::parse($appointment->appointment_end_date)) + 1 }} hari
                                    </span>
                                @else
                                    <span class="text-gray-900 fw-bolder fs-6">-</span>
                                @endif
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="text-gray-700 fw-semibold fs-6 me-2">Dibuat</div>
                            <div class="d-flex align-items-senter">
                                <span class="text-gray-900 fw-bolder fs-6">{{ $appointment->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add User Modal --}}
    <div class="modal fade" tabindex="-1" id="add_user_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Tambah Anggota</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form action="{{ route('back.appointment.add-user', $appointment->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-5">
                            <label class="required form-label">Pilih User</label>
                            <select name="user_id" class="form-select" data-control="select2" data-placeholder="Pilih User" data-dropdown-parent="#add_user_modal" required>
                                <option></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Divisi/Jabatan</label>
                            <input type="text" name="division" class="form-control" placeholder="Divisi/Jabatan dalam penugasan" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit & Delete User Modals --}}
    @foreach ($appointment->appointmentUsers as $au)
        {{-- Edit Modal --}}
        <div class="modal fade" tabindex="-1" id="edit_user_{{ $au->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit Anggota</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.appointment.update-user', [$appointment->id, $au->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-5">
                                <label class="form-label">User</label>
                                <input type="text" class="form-control" value="{{ $au->user->name }}" disabled />
                            </div>
                            <div class="mb-5">
                                <label class="form-label">Divisi/Jabatan</label>
                                <input type="text" name="division" class="form-control" value="{{ $au->division }}" placeholder="Divisi/Jabatan" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div class="modal fade" tabindex="-1" id="delete_user_{{ $au->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Hapus Anggota</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.appointment.remove-user', [$appointment->id, $au->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus <strong>{{ $au->user->name }}</strong> dari penugasan ini?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
