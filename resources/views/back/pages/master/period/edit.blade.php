@extends('back.app')
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form class="form" action="{{ route('back.master.period.update', $period->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card card-flush py-4">
                    <div class="card-header">
                        <div class="card-title">
                            <h2>Edit Periode</h2>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-12 mb-5 fv-row">
                                <label class="required form-label">Nama Periode</label>
                                <input type="text" name="name" class="form-control mb-2"
                                    placeholder="Contoh: Periode 2024-2025" value="{{ old('name', $period->name) }}" required />
                                @error('name')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-5 fv-row">
                                <label class="required form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control mb-2"
                                    value="{{ old('start_date', $period->start_date) }}" required />
                                @error('start_date')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-5 fv-row">
                                <label class="required form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" class="form-control mb-2"
                                    value="{{ old('end_date', $period->end_date) }}" required />
                                @error('end_date')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5 fv-row">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control mb-2" rows="4"
                                placeholder="Deskripsi periode (opsional)">{{ old('description', $period->description) }}</textarea>
                            @error('description')
                                <div class="text-danger fs-7">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <a href="{{ route('back.master.period.index') }}" class="btn btn-light me-5">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
