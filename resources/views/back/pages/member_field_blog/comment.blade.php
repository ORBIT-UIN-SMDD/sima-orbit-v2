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
                        <input type="text" data-kt-comment-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="Cari Komentar" />
                    </div>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <div class="w-100 mw-150px">
                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Status" data-kt-comment-filter="status">
                            <option></option>
                            <option value="all">Semua</option>
                            <option value="approved">Approved</option>
                            <option value="spam">Spam</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_comments_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                        data-kt-check-target="#kt_comments_table .form-check-input" value="1" />
                                </div>
                            </th>
                            <th class="min-w-200px">Komentar</th>
                            <th class="min-w-150px">Blog</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-100px">Tanggal</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-gray-800">{{ $comment->name }}</span>
                                        <span class="text-muted fs-7">{{ $comment->email }}</span>
                                        <span class="text-gray-600 mt-2">{{ Str::limit($comment->comment, 100) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('back.member-field-blog.edit', $comment->blog->id ?? 0) }}"
                                        class="text-gray-800 text-hover-primary fw-bold">
                                        {{ Str::limit($comment->blog->title ?? '-', 50) }}
                                    </a>
                                </td>
                                <td>
                                    @if ($comment->status == 'approved')
                                        <div class="badge badge-light-success">Approved</div>
                                    @else
                                        <div class="badge badge-light-danger">Spam</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">{{ $comment->created_at->format('d M Y H:i') }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                        data-kt-menu="true">
                                        @if ($comment->status == 'spam')
                                            <div class="menu-item px-3">
                                                <form
                                                    action="{{ route('back.member-field-blog.comment.approve', $comment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="menu-link px-3 border-0 bg-transparent w-100 text-start">
                                                        Approve
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <div class="menu-item px-3">
                                                <form
                                                    action="{{ route('back.member-field-blog.comment.spam', $comment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="menu-link px-3 border-0 bg-transparent w-100 text-start">
                                                        Tandai Spam
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                data-bs-target="#delete_comment{{ $comment->id }}">Hapus</a>
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

    @foreach ($comments as $comment)
        <div class="modal fade" tabindex="-1" id="delete_comment{{ $comment->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Hapus Komentar</h3>
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>
                    <form action="{{ route('back.member-field-blog.comment.destroy', $comment->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus komentar dari <strong>{{ $comment->name }}</strong>?</p>
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

        var KTAppComments = function() {
            var table;
            var datatable;

            var initDatatable = function() {
                datatable = $(table).DataTable({
                    "info": false,
                    'order': [],
                    'pageLength': 10,
                    'columnDefs': [{
                            orderable: false,
                            targets: 0
                        },
                        {
                            orderable: false,
                            targets: 5
                        },
                    ]
                });
            }

            var handleSearchDatatable = () => {
                const filterSearch = document.querySelector('[data-kt-comment-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    datatable.search(e.target.value).draw();
                });
            }

            var handleStatusFilter = () => {
                const filterStatus = document.querySelector('[data-kt-comment-filter="status"]');
                $(filterStatus).on('change', e => {
                    let value = e.target.value;
                    if (value === 'all') {
                        value = '';
                    }
                    datatable.column(3).search(value).draw();
                });
            }

            return {
                init: function() {
                    table = document.querySelector('#kt_comments_table');

                    if (!table) {
                        return;
                    }

                    initDatatable();
                    handleSearchDatatable();
                    handleStatusFilter();
                }
            };
        }();

        KTUtil.onDOMContentLoaded(function() {
            KTAppComments.init();
        });
    </script>
@endsection
