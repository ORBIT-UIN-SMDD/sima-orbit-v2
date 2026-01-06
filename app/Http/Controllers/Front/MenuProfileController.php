<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MenuProfile;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuProfileController extends Controller
{
    public function show($slug)
    {
        $setting_web = SettingWebsite::first();
        $menu_profil = MenuProfile::where('slug', $slug)->first();
        $data = [
            'title' => $menu_profil->name,
            'meta' => [
                'title' => $menu_profil->name . ' | ' . $setting_web->name,
                'description' => Str::limit(strip_tags($menu_profil->content), 160),
                'keywords' => $setting_web->name . ', ' . $menu_profil->name .', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa, profile',
                'favicon' => $menu_profil->image ?? $setting_web->favicon
            ],
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Profil',
                ],
                [
                    'name' => $menu_profil->name,
                    'link' => route('profil.show', $menu_profil->slug)
                ]
            ],
            'setting_web' => $setting_web,

            'profil' => $menu_profil,
        ];

        return view('front.pages.menu_profile.show', $data);
    }
}
