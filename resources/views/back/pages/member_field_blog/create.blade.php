@extends('back.app')
@section('content')
    <div id="kt_content_container" class="container-xxl">
        <form id="kt_ecommerce_add_blog_form" class="form d-flex flex-column flex-lg-row"
            action="{{ route('back.member-field-blog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Thumbnail</h2>
                        </div>
                    </div>
                    <div class="card-body text-center pt-0">
                        <style>
                            .image-input-placeholder {
                                background-image: url('{{ asset('back/media/svg/files/blank-image.svg') }}');
                            }

                            [data-bs-theme="dark"] .image-input-placeholder {
                                background-image: url('{{ asset('back/media/svg/files/blank-image-dark.svg') }}');
                            }
                        </style>
                        <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                            data-kt-image-input="true">
                            <div class="image-input-wrapper w-150px h-150px"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah Thumbnail">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input type="file" name="thumbnail" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan Thumbnail">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus Thumbnail">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                        </div>
                        <div class="text-muted fs-7">
                            Set Thumbnail Blog, hanya menerima file dengan ekstensi .png, .jpg, .jpeg
                        </div>
                        @error('thumbnail')
                            <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Status</h2>
                        </div>
                        <div class="card-toolbar">
                            <div class="rounded-circle bg-success w-15px h-15px" id="kt_ecommerce_add_blog_status">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <select name="status" class="form-select mb-2" data-control="select2" data-hide-search="true"
                            data-placeholder="Pilih Status" id="kt_ecommerce_add_blog_status_select" required>
                            <option></option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                        @error('status')
                            <div class="text-danger fs-7">{{ $message }}</div>
                        @enderror
                        <div class="text-muted fs-7">
                            Set Status Blog, <code>Published</code> untuk mempublikasikan blog, <code>Draft</code>
                            untuk menyimpan sebagai draft, <code>Archived</code> untuk menyimpan sebagai arsip
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Blog Bidang</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mb-10 fv-row">
                            <label class="required form-label">Judul</label>
                            <input type="text" name="title" class="form-control mb-2" placeholder="Judul Blog"
                                value="{{ old('title') }}" required />
                            @error('title')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10 fv-row">
                            <label class="required form-label">Bidang</label>
                            <select name="member_field_id" class="form-select mb-2" data-control="select2"
                                data-hide-search="true" data-placeholder="Pilih Bidang" required>
                                <option></option>
                                @foreach ($memberFields as $field)
                                    <option value="{{ $field->id }}"
                                        {{ old('member_field_id') == $field->id ? 'selected' : '' }}>
                                        {{ $field->name }}</option>
                                @endforeach
                            </select>
                            @error('member_field_id')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-10">
                            <label class="required form-label">Konten</label>
                            <div id="quill_content" class="min-h-400px mb-2">
                                {!! old('content') !!}
                            </div>
                            <input type="hidden" name="content" id="content" required>
                            @error('content')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label">Meta Tag Keywords</label>
                            <input id="keyword_tagify" name="meta_keywords" class="form-control mb-2"
                                value="{{ old('meta_keywords') }}" />
                            @error('meta_keywords')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                            <div class="text-muted fs-7">
                                Meta Tag Keywords digunakan untuk SEO, pisahkan dengan koma <code>,</code> jika lebih
                                dari satu keyword yang digunakan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('back.member-field-blog.index') }}" class="btn btn-light me-5">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var quill = new Quill('#quill_content', {
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video', 'formula'],
                    [{
                        header: [1, 2, 3, 4, 5, 6, false]
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }, {
                        'list': 'check'
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                    ['clean']
                ]
            },
            placeholder: 'Tulis konten blog disini...',
            theme: 'snow'
        });

        $("#content").val(quill.root.innerHTML);
        quill.on('text-change', function() {
            $("#content").val(quill.root.innerHTML);
        });

        var tagify = new Tagify(document.querySelector("#keyword_tagify"), {
            whitelist: [],
            dropdown: {
                maxItems: 20,
                classname: "tags-look",
                enabled: 0,
                closeOnSelect: true
            }
        });

        // Status color indicator
        const statusSelect = document.querySelector('#kt_ecommerce_add_blog_status_select');
        const statusIndicator = document.querySelector('#kt_ecommerce_add_blog_status');

        $(statusSelect).on('change', function() {
            switch (this.value) {
                case 'published':
                    statusIndicator.classList.remove('bg-danger', 'bg-primary');
                    statusIndicator.classList.add('bg-success');
                    break;
                case 'draft':
                    statusIndicator.classList.remove('bg-success', 'bg-danger');
                    statusIndicator.classList.add('bg-primary');
                    break;
                case 'archived':
                    statusIndicator.classList.remove('bg-success', 'bg-primary');
                    statusIndicator.classList.add('bg-danger');
                    break;
            }
        });
    </script>
@endsection
