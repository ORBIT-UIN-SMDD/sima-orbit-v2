@extends('back.app')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #locationMap {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            z-index: 1;
        }
    </style>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form id="kt_ecommerce_add_category_form" class="form d-flex flex-column flex-lg-row"
                action="{{ route('back.master.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Foto</h2>
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
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Ubah Foto">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Batalkan">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Hapus Foto">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="text-muted fs-7">
                                Set foto anggota (maks. 2MB)
                            </div>
                            @error('photo')
                                <div class="text-danger fs-7 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Role</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="role_admin" value="1"
                                    @checked(old('role_admin')) id="roleAdmin" />
                                <label class="form-check-label" for="roleAdmin">
                                    Super-Admin/Owner
                                </label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="role_keuangan" value="1"
                                    @checked(old('role_keuangan')) id="roleKeuangan" />
                                <label class="form-check-label" for="roleKeuangan">
                                    Bendahara Keuangan
                                </label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="role_editor" value="1"
                                    @checked(old('role_editor')) id="roleEditor" />
                                <label class="form-check-label" for="roleEditor">
                                    Editor
                                </label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" name="role_humas" value="1"
                                    @checked(old('role_humas')) id="roleHumas" />
                                <label class="form-check-label" for="roleHumas">
                                    Humas
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Status & Permission</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-5">
                                <label class="form-label">Status Aktif</label>
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                        @checked(old('is_active', true)) id="isActive" />
                                    <label class="form-check-label fw-semibold text-muted" for="isActive">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <label class="form-label">Journal Permission</label>
                            @php
                                $permissions = Spatie\Permission\Models\Permission::where('guard_name', 'web')->get();
                            @endphp
                            @foreach ($permissions as $permission)
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                        value="{{ $permission->name }}" @checked(is_array(old('permissions')) && in_array($permission->name, old('permissions')))
                                        id="perm{{ $permission->id }}" />
                                    <label class="form-check-label" for="perm{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Biodata</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">NIM</label>
                                    <input type="text" name="nim" class="form-control mb-2" placeholder="NIM"
                                        value="{{ old('nim') }}" />
                                    @error('nim')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="required form-label">Nama</label>
                                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama Lengkap"
                                        value="{{ old('name') }}" required />
                                    @error('name')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="place_of_birth" class="form-control mb-2"
                                        placeholder="Tempat Lahir" value="{{ old('place_of_birth') }}" />
                                    @error('place_of_birth')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="date_of_birth" class="form-control mb-2"
                                        value="{{ old('date_of_birth') }}" />
                                    @error('date_of_birth')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="gender" class="form-select form-select-solid">
                                        <option value="">-- Pilih --</option>
                                        <option value="laki-laki" @selected(old('gender') == 'laki-laki')>Laki-laki</option>
                                        <option value="perempuan" @selected(old('gender') == 'perempuan')>Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">Golongan Darah</label>
                                    <select name="blood_type" class="form-select form-select-solid">
                                        <option value="">-- Pilih --</option>
                                        <option value="A+" @selected(old('blood_type') == 'A+')>A+</option>
                                        <option value="A-" @selected(old('blood_type') == 'A-')>A-</option>
                                        <option value="B+" @selected(old('blood_type') == 'B+')>B+</option>
                                        <option value="B-" @selected(old('blood_type') == 'B-')>B-</option>
                                        <option value="AB+" @selected(old('blood_type') == 'AB+')>AB+</option>
                                        <option value="AB-" @selected(old('blood_type') == 'AB-')>AB-</option>
                                        <option value="O+" @selected(old('blood_type') == 'O+')>O+</option>
                                        <option value="O-" @selected(old('blood_type') == 'O-')>O-</option>
                                    </select>
                                    @error('blood_type')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">Telepon</label>
                                    <input type="text" name="phone" class="form-control mb-2" placeholder="+628XXXXXXX"
                                        value="{{ old('phone') }}" />
                                    <small class="text-muted">Nomor telepon diawali dengan kode negara, contoh: +62</small>
                                    @error('phone')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="job" class="form-control mb-2" placeholder="Pekerjaan"
                                        value="{{ old('job') }}" />
                                    @error('job')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-5 fv-row">
                                <label class="form-label">Departemen</label>
                                <select name="department_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Pilih Departemen">
                                    <option value="">-- Pilih Departemen --</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}" @selected(old('department_id') == $dept->id)>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5 fv-row">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control mb-2" rows="3" placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5 fv-row">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control mb-2" rows="3" placeholder="Bio singkat">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="text-danger fs-7">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Lokasi</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row mb-5">
                                <div class="col-md-6 fv-row">
                                    <label class="form-label">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control mb-2"
                                        placeholder="Latitude" value="{{ old('latitude') }}" readonly />
                                    @error('latitude')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control mb-2"
                                        placeholder="Longitude" value="{{ old('longitude') }}" readonly />
                                    @error('longitude')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pilih Lokasi di Peta</label>
                                <div id="locationMap"></div>
                                <small class="text-muted">Klik pada peta untuk memilih lokasi</small>
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Akun Login</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="required form-label">Email</label>
                                    <input type="email" name="email" class="form-control mb-2" placeholder="Email"
                                        value="{{ old('email') }}" required />
                                    @error('email')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-5 fv-row">
                                    <label class="required form-label">Password</label>
                                    <input type="password" name="password" class="form-control mb-2"
                                        placeholder="Password" required />
                                    <small class="text-muted">Password minimal 8 karakter</small>
                                    @error('password')
                                        <div class="text-danger fs-7">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('back.master.user.index') }}" class="btn btn-light me-5">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Default koordinat (Bukittinggi)
            var defaultLat = {{ old('latitude', -0.3055) }};
            var defaultLng = {{ old('longitude', 100.3692) }};
            var hasOldValue = {{ old('latitude') ? 'true' : 'false' }};

            var map = L.map('locationMap').setView([defaultLat, defaultLng], hasOldValue ? 15 : 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = null;

            // Jika ada old value, tampilkan marker
            if (hasOldValue) {
                marker = L.marker([defaultLat, defaultLng], {
                    draggable: true
                }).addTo(map);

                marker.on('dragend', function(e) {
                    var position = marker.getLatLng();
                    document.getElementById('latitude').value = position.lat.toFixed(8);
                    document.getElementById('longitude').value = position.lng.toFixed(8);
                });
            }

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;

                document.getElementById('latitude').value = lat.toFixed(8);
                document.getElementById('longitude').value = lng.toFixed(8);

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, {
                        draggable: true
                    }).addTo(map);

                    marker.on('dragend', function(e) {
                        var position = marker.getLatLng();
                        document.getElementById('latitude').value = position.lat.toFixed(8);
                        document.getElementById('longitude').value = position.lng.toFixed(8);
                    });
                }
            });

            // Fix map display issue ketika di dalam tab atau modal
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
@endsection
