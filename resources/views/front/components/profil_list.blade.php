<div class="mb-15 md-mb-50px xs-mb-35px">
    <div
        class="fw-600 fs-19 lh-22 ls-minus-05px text-dark-gray border-bottom border-color-dark-gray border-2 d-block mb-20px pb-10px position-relative">
        profil
    </div>
    @php
        $profil_list = \App\Models\MenuProfile::all();
    @endphp
    <ul class="list-style-03">
        @foreach ($profil_list as $profil)
            <li>
                <a href="{{ route('profil.show', $profil->slug) }}">{{ $profil->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
