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
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Penugasan" />
                    </div>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="w-100 mw-200px">
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Filter Periode" id="filter_period">
                            <option value="">Semua Periode</option>
                            @foreach ($periods as $period)
                                <option value="{{ $period->id }}" {{ $filter_period_id == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <a href="{{ route('back.appointment.create', ['period_id' => $filter_period_id]) }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i>Tambah Penugasan
                    </a>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_appointments">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">No</th>
                            <th class="min-w-200px">Nama Penugasan</th>
                            <th class="min-w-100px">Periode</th>
                            <th class="min-w-150px">Tanggal</th>
                            <th class="min-w-100px">Lokasi</th>
                            <th class="min-w-100px">Anggota</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse ($appointments as $index => $appointment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('back.appointment.show', $appointment->id) }}" class="text-gray-800 text-hover-primary fw-bold">{{ $appointment->name }}</a>
                                        @if($appointment->number)
                                            <span class="text-muted fs-7">No: {{ $appointment->number }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <span class="badge badge-light-primary">{{ $appointment->period->name ?? '-' }}</span>
                                        @if($appointment->period && !$appointment->period->isActive())
                                            <span class="badge badge-light-danger fs-8">Periode Berakhir</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($appointment->appointment_start_date)->format('d M Y') }}</span>
                                        @if($appointment->appointment_end_date)
                                            <span class="text-muted fs-7">s/d {{ \Carbon\Carbon::parse($appointment->appointment_end_date)->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $appointment->location ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-light-info">{{ $appointment->appointmentUsers->count() }} orang</span>
                                </td>
                                <td class="text-end">
                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                    </a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="{{ route('back.appointment.show', $appointment->id) }}" class="menu-link px-3">
                                                <i class="ki-duotone ki-eye fs-5 me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Detail
                                            </a>
                                        </div>
                                        @if($appointment->period && $appointment->period->isActive())
                                            <div class="menu-item px-3">
                                                <a href="{{ route('back.appointment.edit', $appointment->id) }}" class="menu-link px-3">
                                                    <i class="ki-duotone ki-pencil fs-5 me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    Edit
                                                </a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                    data-bs-target="#delete_appointment{{ $appointment->id }}">
                                                    <i class="ki-duotone ki-trash fs-5 me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                    Hapus
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-10">
                                    <i class="ki-duotone ki-document fs-3x text-gray-300 mb-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <p class="mb-0">Belum ada penugasan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Modals --}}
    @foreach ($appointments as $appointment)
        <div class="modal fade" tabindex="-1" id="delete_appointment{{ $appointment->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Hapus Penugasan</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.appointment.destroy', $appointment->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus penugasan <strong>{{ $appointment->name }}</strong>?</p>
                            <p class="text-danger fs-7">Semua anggota yang terkait dengan penugasan ini juga akan dihapus.</p>
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
        // Filter by period
        document.getElementById('filter_period').addEventListener('change', function() {
            var periodId = this.value;
            var url = '{{ route("back.appointment.manage") }}';

            if (periodId) {
                url += '?period_id=' + periodId;
            }

            window.location.href = url;
        });

        // Search functionality
        var searchInput = document.querySelector('[data-kt-filter="search"]');
        searchInput.addEventListener('keyup', function(e) {
            var value = e.target.value.toLowerCase();
            var rows = document.querySelectorAll('#kt_table_appointments tbody tr');

            rows.forEach(function(row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    </script>
@endsection
