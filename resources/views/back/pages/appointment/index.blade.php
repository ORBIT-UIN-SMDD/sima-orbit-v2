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
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_appointments">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-50px">No</th>
                            <th class="min-w-200px">Nama Penugasan</th>
                            <th class="min-w-150px">Periode</th>
                            <th class="min-w-100px">Divisi</th>
                            <th class="min-w-150px">Tanggal</th>
                            <th class="min-w-100px">Lokasi</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @forelse ($appointmentUsers as $index => $au)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800 fw-bold">{{ $au->appointment->name }}</span>
                                        @if($au->appointment->number)
                                            <span class="text-muted fs-7">No: {{ $au->appointment->number }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light-primary">{{ $au->appointment->period->name ?? '-' }}</span>
                                </td>
                                <td>{{ $au->division ?? '-' }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($au->appointment->appointment_start_date)->format('d M Y') }}</span>
                                        @if($au->appointment->appointment_end_date)
                                            <span class="text-muted fs-7">s/d {{ \Carbon\Carbon::parse($au->appointment->appointment_end_date)->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $au->appointment->location ?? '-' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('back.appointment.show', $au->appointment->id) }}"
                                        class="btn btn-sm btn-light btn-active-light-primary">
                                        <i class="ki-duotone ki-eye fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Detail
                                    </a>
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
@endsection

@section('scripts')
    <script>
        // Filter by period
        document.getElementById('filter_period').addEventListener('change', function() {
            var periodId = this.value;
            var url = '{{ route("back.appointment.index") }}';

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
