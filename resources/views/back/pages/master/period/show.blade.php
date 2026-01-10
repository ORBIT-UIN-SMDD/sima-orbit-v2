@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        {{-- Info Periode --}}
        <div class="card card-flush mb-6">
            <div class="card-header pt-5">
                <div class="card-title">
                    <h2>{{ $period->name }}</h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('back.master.period.edit', $period->id) }}" class="btn btn-sm btn-light-primary">
                        <i class="ki-duotone ki-pencil fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Edit Periode
                    </a>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ki-duotone ki-calendar fs-2 text-primary me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div>
                                <span class="text-muted fs-7 d-block">Tanggal Mulai</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($period->start_date)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ki-duotone ki-calendar-tick fs-2 text-success me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                                <span class="path6"></span>
                            </i>
                            <div>
                                <span class="text-muted fs-7 d-block">Tanggal Selesai</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($period->end_date)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="ki-duotone ki-people fs-2 text-info me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                            <div>
                                <span class="text-muted fs-7 d-block">Total Anggota</span>
                                <span class="fw-bold">{{ $periodUsers->count() }} Orang</span>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($period->description)
                    <div class="mt-3">
                        <span class="text-muted fs-7 d-block mb-1">Deskripsi</span>
                        <p class="mb-0">{{ $period->description }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Daftar Anggota --}}
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <h3 class="m-0">Daftar Anggota Periode</h3>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Anggota" />
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_user_modal">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Anggota
                    </button>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_period_users_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-150px">Anggota</th>
                            <th class="min-w-100px">Jabatan</th>
                            <th class="min-w-100px">Bidang</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($periodUsers as $pu)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-circle symbol-40px me-3">
                                            @if ($pu->user && $pu->user->photo)
                                                <img src="{{ Storage::url($pu->user->photo) }}" alt="{{ $pu->user->name ?? '-' }}" />
                                            @else
                                                <div class="symbol-label bg-light-primary text-primary fw-bold">
                                                    {{ $pu->user ? substr($pu->user->name, 0, 1) : '-' }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-gray-800 fw-bold">{{ $pu->user->name ?? '-' }}</span>
                                            <span class="text-muted fs-7">{{ $pu->user->email ?? '-' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $roleColors = [
                                            'Ketua Umum' => 'badge-light-danger',
                                            'Wakil Ketua Umum' => 'badge-light-warning',
                                            'Sekretaris Umum' => 'badge-light-info',
                                            'Bendahara Umum' => 'badge-light-success',
                                            'Kepala Bidang' => 'badge-light-primary',
                                            'Sekretaris Bidang' => 'badge-light-info',
                                            'Bendahara Bidang' => 'badge-light-success',
                                            'Anggota Bidang' => 'badge-light-dark',
                                            'Anggota' => 'badge-light-secondary',
                                        ];
                                    @endphp
                                    <span class="badge {{ $roleColors[$pu->role] ?? 'badge-light-secondary' }}">{{ $pu->role }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ $pu->memberField->name ?? '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#edit_user_modal{{ $pu->id }}">Edit</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#delete_user_modal{{ $pu->id }}">Hapus</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Anggota --}}
    <div class="modal fade" tabindex="-1" id="add_user_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Tambah Anggota</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <form action="{{ route('back.master.period.add-user', $period->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-5">
                            <label class="required form-label">Pilih User</label>
                            <select name="user_id" class="form-select" data-control="select2"
                                data-placeholder="Pilih User" data-dropdown-parent="#add_user_modal" required>
                                <option></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="required form-label">Jabatan</label>
                            <select name="role" class="form-select" data-control="select2"
                                data-placeholder="Pilih Jabatan" data-dropdown-parent="#add_user_modal" required>
                                <option></option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Bidang</label>
                            <select name="member_field_id" class="form-select" data-control="select2"
                                data-placeholder="Pilih Bidang (Opsional)" data-dropdown-parent="#add_user_modal"
                                data-allow-clear="true">
                                <option></option>
                                @foreach ($memberFields as $field)
                                    <option value="{{ $field->id }}">{{ $field->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-muted fs-7 mt-1">Pilih bidang jika jabatan terkait dengan bidang tertentu</div>
                            @error('member_field_id')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
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

    {{-- Modal Edit & Delete untuk setiap anggota --}}
    @foreach ($periodUsers as $pu)
        {{-- Modal Edit --}}
        <div class="modal fade" tabindex="-1" id="edit_user_modal{{ $pu->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Edit Anggota</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.master.period.update-user', [$period->id, $pu->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="d-flex align-items-center mb-5 pb-5 border-bottom">
                                <div class="symbol symbol-circle symbol-50px me-3">
                                    @if ($pu->user && $pu->user->photo)
                                        <img src="{{ Storage::url($pu->user->photo) }}" alt="{{ $pu->user->name ?? '-' }}" />
                                    @else
                                        <div class="symbol-label bg-light-primary text-primary fw-bold fs-4">
                                            {{ $pu->user ? substr($pu->user->name, 0, 1) : '-' }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-gray-800 fw-bold fs-5">{{ $pu->user->name ?? '-' }}</span>
                                    <span class="text-muted d-block fs-7">{{ $pu->user->email ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="required form-label">Jabatan</label>
                                <select name="role" class="form-select" data-control="select2"
                                    data-placeholder="Pilih Jabatan" data-dropdown-parent="#edit_user_modal{{ $pu->id }}" required>
                                    <option></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}" {{ $pu->role == $role ? 'selected' : '' }}>
                                            {{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Bidang</label>
                                <select name="member_field_id" class="form-select" data-control="select2"
                                    data-placeholder="Pilih Bidang (Opsional)" data-dropdown-parent="#edit_user_modal{{ $pu->id }}"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach ($memberFields as $field)
                                        <option value="{{ $field->id }}" {{ $pu->member_field_id == $field->id ? 'selected' : '' }}>
                                            {{ $field->name }}</option>
                                    @endforeach
                                </select>
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

        {{-- Modal Delete --}}
        <div class="modal fade" tabindex="-1" id="delete_user_modal{{ $pu->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Hapus Anggota</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.master.period.remove-user', [$period->id, $pu->id]) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus <strong>{{ $pu->user->name ?? '-' }}</strong> dari periode ini?</p>
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

@section('scripts')
    <script>
        "use strict";

        var KTAppPeriodUsers = function() {
            var table;
            var datatable;

            var initDatatable = function() {
                datatable = $(table).DataTable({
                    "info": false,
                    'order': [],
                    'pageLength': 10,
                    'columnDefs': [{
                        orderable: false,
                        targets: 3
                    }]
                });
            }

            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-kt-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    datatable.search(e.target.value).draw();
                });
            }

            return {
                init: function() {
                    table = document.querySelector('#kt_period_users_table');
                    if (!table) return;
                    initDatatable();
                    handleSearchDatatable();
                }
            };
        }();

        KTUtil.onDOMContentLoaded(function() {
            KTAppPeriodUsers.init();
        });
    </script>
@endsection
