@extends('front.app')

@section('seo')
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="author" content="UKM Orbit UIN Sjech M.Djamil Djambek Bukittinggi">

    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('alumni.index') }}">
    <link rel="canonical" href="{{ route('alumni.index') }}">
    <meta property="og:image" content="{{ Storage::url($meta['favicon']) }}">
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <style>
        #alumni-map {
            height: 80vh;
            min-height: 500px;
            width: 100%;
            border-radius: 15px;
        }
        .map-wrapper {
            padding: 0 30px 30px 30px;
        }
        .alumni-popup {
            min-width: 200px;
        }
        .alumni-popup img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .alumni-popup h6 {
            margin-bottom: 5px;
            font-weight: 600;
        }
        .alumni-popup p {
            margin-bottom: 3px;
            font-size: 13px;
        }
        .alumni-popup .bio-text {
            font-style: italic;
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .alumni-popup .periods-list {
            text-align: left;
            margin-top: 10px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .alumni-popup .periods-list h6 {
            font-size: 13px;
            margin-bottom: 8px;
            color: #333;
        }
        /* Custom Marker Icon */
        .custom-alumni-marker {
            background: transparent;
            border: none;
        }
        .custom-alumni-marker .marker-pin {
            width: 25px;
            height: 41px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 25 41'%3E%3Cpath fill='%2315365F' d='M12.5 0C5.6 0 0 5.6 0 12.5c0 2.4.7 4.6 1.9 6.5L12.5 41l10.6-22c1.2-1.9 1.9-4.1 1.9-6.5C25 5.6 19.4 0 12.5 0z'/%3E%3Ccircle fill='%23ffffff' cx='12.5' cy='12.5' r='5'/%3E%3C/svg%3E");
            background-size: contain;
            background-repeat: no-repeat;
        }
        .alumni-popup .period-item {
            background: #f8f9fa;
            padding: 8px 10px;
            border-radius: 6px;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .alumni-popup .period-item .period-name {
            font-weight: 600;
            color: #333;
        }
        .alumni-popup .period-item .period-role {
            color: #667eea;
        }
        .alumni-popup .period-item .period-field {
            color: #888;
        }
        .map-controls {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            margin-bottom: 15px;
        }
        .map-controls .form-control, .map-controls .form-select {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .map-controls .form-control:focus, .map-controls .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .alumni-count {
            font-size: 14px;
            color: #666;
        }
        .alumni-count strong {
            color: #333;
        }
    </style>
@endsection

@section('content')
    @include('front.components.breadcrumb')

    <section class="p-0">
        <div class="map-wrapper">
            <div class="map-controls">
                <div class="row align-items-center g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-search text-muted"></i></span>
                            <input type="text" id="search-alumni" class="form-control border-start-0" placeholder="Cari nama alumni...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select id="filter-period" class="form-select">
                            <option value="">Semua Periode</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}">{{ $period->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <span class="alumni-count">Menampilkan <strong id="visible-count">{{ $alumniForMap->count() }}</strong> dari <strong>{{ $alumniForMap->count() }}</strong> alumni</span>
                    </div>
                </div>
            </div>
            <div id="alumni-map"></div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('alumni-map').setView([-0.5, 117.0], 5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var markers = L.markerClusterGroup({
                chunkedLoading: true,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: false,
                zoomToBoundsOnClick: true,
                maxClusterRadius: 50
            });

            var alumniData = @json($alumniForMap);
            var allMarkers = [];

            // Custom marker icon
            var alumniIcon = L.divIcon({
                className: 'custom-alumni-marker',
                html: '<div class="marker-pin"></div>',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [0, -41]
            });

            // Create markers with alumni data attached
            alumniData.forEach(function(alumni) {
                // Build periods list HTML
                var periodsHtml = '';
                if (alumni.periods && alumni.periods.length > 0) {
                    periodsHtml = '<div class="periods-list"><h6><i class="fa-solid fa-history me-1"></i>Riwayat Periode</h6>';
                    alumni.periods.forEach(function(p) {
                        periodsHtml += `
                            <div class="period-item">
                                <div class="period-name">${p.period_name}</div>
                                <div class="period-role"><i class="fa-solid fa-user-tag me-1"></i>${p.role}</div>
                                <div class="period-field"><i class="fa-solid fa-layer-group me-1"></i>${p.member_field}</div>
                            </div>
                        `;
                    });
                    periodsHtml += '</div>';
                }

                var popupContent = `
                    <div class="alumni-popup text-center">
                        <img src="${alumni.photo}" alt="${alumni.name}">
                        <h6>${alumni.name}</h6>
                        <p><i class="fa-solid fa-venus-mars me-1"></i>${alumni.gender}</p>
                        <p><i class="fa-solid fa-briefcase me-1"></i>${alumni.job}</p>
                        <p class="bio-text">${alumni.bio}</p>
                        ${periodsHtml}
                    </div>
                `;

                var marker = L.marker([alumni.latitude, alumni.longitude], {icon: alumniIcon}).bindPopup(popupContent);
                marker.alumniData = alumni;
                allMarkers.push(marker);
            });

            // Initial load all markers
            allMarkers.forEach(function(marker) {
                markers.addLayer(marker);
            });
            map.addLayer(markers);

            // Fit bounds
            function fitMapBounds() {
                if (markers.getLayers().length > 0) {
                    var group = new L.featureGroup(markers.getLayers());
                    map.fitBounds(group.getBounds().pad(0.1));
                }
            }
            fitMapBounds();

            // Filter function
            function filterMarkers() {
                var searchTerm = document.getElementById('search-alumni').value.toLowerCase();
                var periodId = document.getElementById('filter-period').value;
                var visibleCount = 0;

                markers.clearLayers();

                allMarkers.forEach(function(marker) {
                    var alumni = marker.alumniData;
                    var matchSearch = alumni.name.toLowerCase().includes(searchTerm) ||
                                      alumni.job.toLowerCase().includes(searchTerm) ||
                                      alumni.address.toLowerCase().includes(searchTerm) ||
                                      alumni.department.toLowerCase().includes(searchTerm);
                    var matchPeriod = periodId === '' || alumni.period_id == periodId;

                    if (matchSearch && matchPeriod) {
                        markers.addLayer(marker);
                        visibleCount++;
                    }
                });

                document.getElementById('visible-count').textContent = visibleCount;

                if (visibleCount > 0) {
                    fitMapBounds();
                }
            }

            // Event listeners
            document.getElementById('search-alumni').addEventListener('input', filterMarkers);
            document.getElementById('filter-period').addEventListener('change', filterMarkers);
        });
    </script>
@endsection
