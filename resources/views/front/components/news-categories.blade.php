@php
    $categories = \App\Models\NewsCategory::with('news')->get();
@endphp

<div class="mb-15 md-mb-50px xs-mb-35px">
    <div
        class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-30px pb-15px position-relative">
        Kategori Berita</div>
    <ul class="category-list-sidebar position-relative">
        @foreach ($categories as $category)
        <li class="d-flex align-items-center h-80px cover-background ps-35px pe-35px"
            style="background-image: url('{{ asset("img_ext/category_img.jpg") }}');">
            <div class="opacity-medium bg-gradient-dark-transparent"></div>
            <a href="{{ route('news.category', $category->slug) }}" class="d-flex align-items-center position-relative w-100 h-100">
                <span class="text-white mb-0 fs-20 fw-500 fancy-text-style-4">{{ $category->name }} ({{ $category->news->count() }})</span>
                <span class="btn text-white position-absolute"><i class="bi bi-arrow-right ms-0 fs-24"></i></span>
            </a>
        </li>
 @endforeach
    </ul>
</div>
