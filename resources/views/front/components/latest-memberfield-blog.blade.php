@php
    $latestBlogs = \App\Models\MemberFieldBlog::with(['memberField', 'user'])
        ->where('status', 'published')
        ->latest()
        ->limit(5)
        ->get();
@endphp

<div class="mb-15 md-mb-50px xs-mb-35px">
    <div class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-30px pb-15px position-relative">
        Blog Terbaru
    </div>
    @forelse ($latestBlogs as $blog)
        <div class="d-flex align-items-center mb-20px pb-20px border-bottom border-color-extra-medium-gray">
            <figure class="mb-0 flex-shrink-0">
                <a href="{{ route('memberfield.show', $blog->slug) }}">
                    <img src="{{ $blog->getThumbnail() }}" class="rounded" style="width: 100px; height: 70px; object-fit: cover;" alt="{{ $blog->title }}">
                </a>
            </figure>
            <div class="ps-20px last-paragraph-no-margin">
                <a href="{{ route('memberfield.show', $blog->slug) }}" class="text-dark-gray fw-500 lh-22 d-block mb-5px">
                    {{ Str::limit($blog->title, 50) }}
                </a>
                <span class="fs-13 text-light-gray">
                    <i class="feather icon-feather-calendar me-5px"></i>{{ $blog->created_at->format('d M Y') }}
                </span>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada blog</p>
    @endforelse
</div>
