@extends('front.app')

@section('seo')
<title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('member') }}">
    <link rel="canonical" href="{{ route('member') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
<style>
    .member-card {
        transition: all 0.3s ease;
    }
    .member-card:hover {
        transform: translateY(-5px);
    }
    .member-photo {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
    }
    .period-select {
        max-width: 400px;
        margin: 0 auto;
    }
    .member-grid {
        min-height: 300px;
    }
    .loading-spinner {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 300px;
    }
    .field-group {
        margin-bottom: 40px;
    }
    .field-title {
        border-left: 4px solid #C3A356;
        padding-left: 15px;
        margin-bottom: 25px;
    }
</style>
@endsection

@section('content')
    @include('front.components.breadcrumb')

    <section class=" background-position-center-top sm-background-image-none" style="background-image: url('{{ asset('front/images/vertical-line-bg-medium-gray.svg') }}')">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-xl-6 col-lg-8 text-center">
                    <h3 class="fw-600 text-dark-gray ls-minus-1px mb-4">Pengurus & Anggota Organisasi</h3>
                    <p class="text-muted mb-4">Pilih periode untuk melihat daftar pengurus & anggota</p>

                    {{-- Period Dropdown --}}
                    <div class="period-select">
                        <select id="periodSelect" class="form-select form-select-lg border-2">
                            <option value="">-- Pilih Periode --</option>
                            @foreach ($period as $index => $p)
                                <option value="{{ $p->id }}" {{ $index === 0 ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Loading Spinner --}}
            <div id="loadingSpinner" class="loading-spinner d-none">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            {{-- Empty State --}}
            <div id="emptyState" class="text-center py-5 d-none">
                <i class="bi bi-people fs-1 text-muted mb-3 d-block"></i>
                <p class="text-muted">Silakan pilih periode untuk menampilkan daftar pengurus & anggota</p>
            </div>

            {{-- Member Container --}}
            <div id="memberContainer" class="d-none">
                {{-- Members will be loaded here via AJAX --}}
            </div>
        </div>
    </section>

    @include('front.partials.sima-orbit-banner')
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const periodSelect = document.getElementById('periodSelect');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const emptyState = document.getElementById('emptyState');
        const memberContainer = document.getElementById('memberContainer');

        function loadMembers(periodId) {
            if (!periodId) {
                emptyState.classList.remove('d-none');
                memberContainer.classList.add('d-none');
                memberContainer.innerHTML = '';
                return;
            }

            // Show loading, hide others
            loadingSpinner.classList.remove('d-none');
            emptyState.classList.add('d-none');
            memberContainer.classList.add('d-none');

            // Fetch members via AJAX
            fetch('{{ route("member.ajax") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    periods_id: [periodId]
                })
            })
            .then(response => response.json())
            .then(data => {
                loadingSpinner.classList.add('d-none');

                if (data.length === 0 || (data[0] && data[0].period_users && data[0].period_users.length === 0)) {
                    emptyState.innerHTML = `
                        <i class="bi bi-people fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted">Belum ada pengurus pada periode ini</p>
                    `;
                    emptyState.classList.remove('d-none');
                    return;
                }

                // Group members by member_field
                let html = '';

                // Define Polis Umum roles
                const polisUmumRoles = ['Ketua Umum', 'Wakil Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum'];
                const roleOrder = {
                    'Ketua Umum': 1,
                    'Wakil Ketua Umum': 2,
                    'Sekretaris Umum': 3,
                    'Bendahara Umum': 4
                };

                data.forEach(period => {
                    if (!period.period_users || period.period_users.length === 0) return;

                    // Separate Polis Umum members and others
                    const polisUmumMembers = [];
                    const otherMembers = [];

                    period.period_users.forEach(pu => {
                        if (polisUmumRoles.includes(pu.role)) {
                            polisUmumMembers.push(pu);
                        } else {
                            otherMembers.push(pu);
                        }
                    });

                    // Sort Polis Umum by role order
                    polisUmumMembers.sort((a, b) => (roleOrder[a.role] || 99) - (roleOrder[b.role] || 99));

                    // Render Polis Umum first
                    if (polisUmumMembers.length > 0) {
                        html += `
                            <div class="field-group">
                                <h4 class="field-title fw-600 text-dark-gray">Polis Umum</h4>
                                <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 g-4">
                        `;

                        polisUmumMembers.forEach(member => {
                            const user = member.user;
                            const photo = user.photo
                                ? (user.photo.startsWith('http') ? user.photo : '/storage/' + user.photo)
                                : `https://ui-avatars.com/api/?background=15365F&color=C3A356&size=256&name=${encodeURIComponent(user.name)}`;

                            html += `
                                <div class="col text-center">
                                    <div class="member-card bg-white border-radius-6px overflow-hidden box-shadow-small">
                                        <a href="/user/${user.id}">
                                            <img src="${photo}" alt="${user.name}" class="member-photo border-radius-6px-top" />
                                        </a>
                                        <div class="p-20px">
                                            <a href="/user/${user.id}" class="fs-17 d-block fw-600 text-dark-gray lh-24 ls-minus-05px text-decoration-none">${user.name}</a>
                                            <p class="m-0 text-muted fs-14">${member.role || '-'}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `
                                </div>
                            </div>
                        `;
                    }

                    // Group remaining members by member_field
                    const grouped = {};
                    otherMembers.forEach(pu => {
                        const fieldName = pu.member_field ? pu.member_field.name : 'Lainnya';
                        const fieldId = pu.member_field ? pu.member_field.id : 0;
                        const fieldOrder = pu.member_field ? pu.member_field.order : 999;

                        if (!grouped[fieldId]) {
                            grouped[fieldId] = {
                                name: fieldName,
                                order: fieldOrder,
                                members: []
                            };
                        }
                        grouped[fieldId].members.push(pu);
                    });

                    // Sort by field order
                    const sortedFields = Object.values(grouped).sort((a, b) => a.order - b.order);

                    sortedFields.forEach(field => {
                        html += `
                            <div class="field-group">
                                <h4 class="field-title fw-600 text-dark-gray">${field.name}</h4>
                                <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 g-4">
                        `;

                        field.members.forEach(member => {
                            const user = member.user;
                            const photo = user.photo
                                ? (user.photo.startsWith('http') ? user.photo : '/storage/' + user.photo)
                                : `https://ui-avatars.com/api/?background=15365F&color=C3A356&size=256&name=${encodeURIComponent(user.name)}`;

                            html += `
                                <div class="col text-center">
                                    <div class="member-card bg-white border-radius-6px overflow-hidden box-shadow-small">
                                        <a href="/user/${user.id}">
                                            <img src="${photo}" alt="${user.name}" class="member-photo border-radius-6px-top" />
                                        </a>
                                        <div class="p-20px">
                                            <a href="/user/${user.id}" class="fs-17 d-block fw-600 text-dark-gray lh-24 ls-minus-05px text-decoration-none">${user.name}</a>
                                            <p class="m-0 text-muted fs-14">${member.role || '-'}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        html += `
                                </div>
                            </div>
                        `;
                    });
                });

                memberContainer.innerHTML = html;
                memberContainer.classList.remove('d-none');
            })
            .catch(error => {
                console.error('Error:', error);
                loadingSpinner.classList.add('d-none');
                emptyState.innerHTML = `
                    <i class="bi bi-exclamation-triangle fs-1 text-danger mb-3 d-block"></i>
                    <p class="text-danger">Terjadi kesalahan saat memuat data</p>
                `;
                emptyState.classList.remove('d-none');
            });
        }

        periodSelect.addEventListener('change', function() {
            loadMembers(this.value);
        });

        // Load default selected period on page load
        if (periodSelect.value) {
            loadMembers(periodSelect.value);
        }
    });
</script>
@endsection
