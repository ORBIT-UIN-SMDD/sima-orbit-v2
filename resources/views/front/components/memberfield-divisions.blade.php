@php
    $memberFields = \App\Models\MemberField::withCount(['blogs' => function($query) {
        $query->where('status', 'published');
    }])->get();
@endphp

<div class="mb-15 md-mb-50px xs-mb-35px">
    <div class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-30px pb-15px position-relative">
        Bidang
    </div>
    <ul class="list-unstyled mb-0">
        @forelse ($memberFields as $field)
            <li class="mb-15px">
                <a href="{{ route('memberfield.division', $field->slug) }}" class="d-flex align-items-center text-dark-gray text-dark-gray-hover">
                    <span class="fw-500">{{ $field->name }}</span>
                    <span class="ms-auto badge bg-dark-gray rounded-pill">{{ $field->blogs_count }}</span>
                </a>
            </li>
        @empty
            <li class="text-muted">Belum ada bidang</li>
        @endforelse
    </ul>
</div>
