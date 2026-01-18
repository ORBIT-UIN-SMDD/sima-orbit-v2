@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form class="form" action="{{ route('back.appointment.update', $appointment->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Edit Penugasan</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Nama Penugasan</label>
                                <input type="text" name="name" class="form-control mb-2"
                                    placeholder="Nama Penugasan" value="{{ old('name', $appointment->name) }}" required />
                                @error('name')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Periode</label>
                                <select name="period_id" class="form-select mb-2" data-control="select2"
                                    data-placeholder="Pilih Periode" required>
                                    <option></option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period->id }}"
                                            {{ old('period_id', $appointment->period_id) == $period->id ? 'selected' : '' }}>
                                            {{ $period->name }}</option>
                                    @endforeach
                                </select>
                                @error('period_id')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Tanggal Mulai</label>
                                <input type="date" name="appointment_start_date" class="form-control mb-2"
                                    value="{{ old('appointment_start_date', $appointment->appointment_start_date ? \Carbon\Carbon::parse($appointment->appointment_start_date)->format('Y-m-d') : '') }}" required />
                                @error('appointment_start_date')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="appointment_end_date" class="form-control mb-2"
                                    value="{{ old('appointment_end_date', $appointment->appointment_end_date ? \Carbon\Carbon::parse($appointment->appointment_end_date)->format('Y-m-d') : '') }}" />
                                @error('appointment_end_date')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Nomor SK/Surat</label>
                                <input type="text" name="number" class="form-control mb-2"
                                    placeholder="Nomor SK/Surat" value="{{ old('number', $appointment->number) }}" />
                                @error('number')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Penyelenggara</label>
                                <input type="text" name="organizer" class="form-control mb-2"
                                    placeholder="Penyelenggara" value="{{ old('organizer', $appointment->organizer) }}" />
                                @error('organizer')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="location" class="form-control mb-2"
                                    placeholder="Lokasi" value="{{ old('location', $appointment->location) }}" />
                                @error('location')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">File SK/Surat</label>
                                <input type="file" name="file_sk" class="form-control mb-2" accept=".pdf,.doc,.docx" />
                                @if($appointment->file_sk)
                                    <div class="mt-2">
                                        <span class="text-muted fs-7">File saat ini: </span>
                                        <a href="{{ Storage::url($appointment->file_sk) }}" target="_blank" class="text-primary">
                                            <i class="ki-duotone ki-file fs-5">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            Lihat File
                                        </a>
                                    </div>
                                @endif
                                <div class="text-muted fs-7">Format: PDF, DOC, DOCX. Maksimal 5MB.</div>
                                @error('file_sk')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control mb-2" rows="4" placeholder="Deskripsi penugasan">{{ old('description', $appointment->description) }}</textarea>
                        @error('description')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="notice d-flex bg-light-info rounded border-info border border-dashed p-6">
                        <i class="ki-duotone ki-information fs-2tx text-info me-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="d-flex flex-stack flex-grow-1">
                            <div class="fw-semibold">
                                <div class="fs-6 text-gray-700">
                                    Untuk mengelola anggota penugasan, silakan kunjungi halaman
                                    <a href="{{ route('back.appointment.show', $appointment->id) }}">Detail Penugasan</a>.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('back.appointment.manage') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
