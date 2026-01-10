@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Periode" />
                    </div>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <a href="{{ route('back.master.period.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Periode</a>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_periods_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Nama Periode</th>
                            <th class="min-w-100px">Tanggal Mulai</th>
                            <th class="min-w-100px">Tanggal Selesai</th>
                            <th class="min-w-80px">Jumlah Anggota</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($periods as $period)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('back.master.period.show', $period->id) }}"
                                            class="text-gray-800 text-hover-primary fw-bold">{{ $period->name }}</a>
                                        @if ($period->description)
                                            <span class="text-muted fs-7">{{ Str::limit($period->description, 50) }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($period->start_date)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">{{ \Carbon\Carbon::parse($period->end_date)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-light-primary fs-7">{{ $period->period_users_count }} Anggota</span>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.master.period.show', $period->id) }}"
                                                class="menu-link px-3">
                                                <i class="ki-duotone ki-eye fs-5 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>Detail
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.master.period.edit', $period->id) }}"
                                                class="menu-link px-3">
                                                <i class="ki-duotone ki-pencil fs-5 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>Edit
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#delete_period{{ $period->id }}">
                                                <i class="ki-duotone ki-trash fs-5 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>Hapus
                                            </a>
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

    @foreach ($periods as $period)
        <div class="modal fade" tabindex="-1" id="delete_period{{ $period->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Hapus Periode</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.master.period.destroy', $period->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus periode <strong>{{ $period->name }}</strong>?</p>
                            <p class="text-danger fs-7">Semua data anggota dalam periode ini juga akan dihapus.</p>
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

        var KTAppPeriods = function() {
            var table;
            var datatable;

            var initDatatable = function() {
                datatable = $(table).DataTable({
                    "info": false,
                    'order': [],
                    'pageLength': 10,
                    'columnDefs': [{
                        orderable: false,
                        targets: 4
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
                    table = document.querySelector('#kt_periods_table');
                    if (!table) return;
                    initDatatable();
                    handleSearchDatatable();
                }
            };
        }();

        KTUtil.onDOMContentLoaded(function() {
            KTAppPeriods.init();
        });
    </script>
@endsection
