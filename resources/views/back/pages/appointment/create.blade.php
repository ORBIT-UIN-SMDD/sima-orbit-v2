@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form class="form" action="{{ route('back.appointment.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-flush py-4">
                <div class="card-header">
                    <div class="card-title">
                        <h2>Tambah Penugasan</h2>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Nama Penugasan</label>
                                <input type="text" name="name" class="form-control mb-2"
                                    placeholder="Nama Penugasan" value="{{ old('name') }}" required />
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
                                            {{ old('period_id', $selected_period_id ?? '') == $period->id ? 'selected' : '' }}>
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
                                    value="{{ old('appointment_start_date') }}" required />
                                @error('appointment_start_date')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="appointment_end_date" class="form-control mb-2"
                                    value="{{ old('appointment_end_date') }}" />
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
                                    placeholder="Nomor SK/Surat" value="{{ old('number') }}" />
                                @error('number')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">Penyelenggara</label>
                                <input type="text" name="organizer" class="form-control mb-2"
                                    placeholder="Penyelenggara" value="{{ old('organizer') }}" />
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
                                    placeholder="Lokasi" value="{{ old('location') }}" />
                                @error('location')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-10 fv-row">
                                <label class="form-label">File SK/Surat</label>
                                <input type="file" name="file_sk" class="form-control mb-2" accept=".pdf,.doc,.docx" />
                                <div class="text-muted fs-7">Format: PDF, DOC, DOCX. Maksimal 5MB.</div>
                                @error('file_sk')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-10 fv-row">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control mb-2" rows="4" placeholder="Deskripsi penugasan">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Dynamic Users Section --}}
                    <div class="mb-10">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <label class="form-label mb-0">Anggota Penugasan</label>
                            <button type="button" class="btn btn-sm btn-light-primary" id="add_user_row">
                                <i class="ki-duotone ki-plus fs-3"></i> Tambah Anggota
                            </button>
                        </div>
                        <div id="users_container">
                            {{-- User rows will be added here --}}
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('back.appointment.manage') }}" class="btn btn-light me-3">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var userIndex = 0;
        var users = @json($users);

        document.getElementById('add_user_row').addEventListener('click', function() {
            addUserRow();
        });

        function addUserRow() {
            var container = document.getElementById('users_container');
            var row = document.createElement('div');
            row.className = 'row mb-5 user-row';
            row.innerHTML = `
                <div class="col-md-5">
                    <select name="users[]" class="form-select user-select" data-control="select2" data-placeholder="Pilih User">
                        <option></option>
                        ${users.map(u => `<option value="${u.id}">${u.name}</option>`).join('')}
                    </select>
                </div>
                <div class="col-md-5">
                    <input type="text" name="divisions[]" class="form-control" placeholder="Divisi/Jabatan" />
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-light-danger w-100" onclick="removeUserRow(this)">
                        <i class="ki-duotone ki-trash fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </button>
                </div>
            `;
            container.appendChild(row);

            // Initialize Select2 for the new select
            $(row).find('.user-select').select2({
                placeholder: 'Pilih User'
            });

            userIndex++;
        }

        function removeUserRow(btn) {
            btn.closest('.user-row').remove();
        }

        // Add initial row
        addUserRow();
    </script>
@endsection
