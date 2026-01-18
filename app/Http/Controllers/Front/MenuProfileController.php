<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MenuProfile;
use App\Models\Period;
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
                'keywords' => $setting_web->name . ', ' . $menu_profil->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa, profile',
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

    public function committe()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Pengurus',
            'meta' => [
                'title' => 'Pengurus | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', Pengurus, ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
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
                    'name' => 'Pengurus',
                    'link' => route('committe')
                ]
            ],
            'setting_web' => $setting_web,
            'period' => Period::orderBy('end_date', 'desc')->get(),
        ];
        return view('front.pages.menu_profile.committe', $data);
    }
    public function member()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Anggota',
            'meta' => [
                'title' => 'Anggota | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', Anggota, ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
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
                    'name' => 'Anggota',
                    'link' => route('member')
                ]
            ],
            'setting_web' => $setting_web,
            'period' => Period::orderBy('end_date', 'desc')->get(),
        ];
        return view('front.pages.menu_profile.member', $data);
    }
    public function memberAjax(Request $request)
    {
        $periodsId = $request->input('periods_id');
        if ($periodsId) {
            $periods = Period::with(['periodUsers' => function ($query) use ($periodsId) {
                $query->whereIn('period_id', $periodsId)
                    ->where('role', 'Anggota'); // Filter hanya anggota
            }, 'periodUsers.user', 'periodUsers.memberField'])->whereIn('id', $periodsId)->get();
            return response()->json($periods);
        } else {
            return response()->json(['message' => 'No periods_id provided'], 400);
        }
    }

    public function committeAjax(Request $request)
    {
        $periodsId = $request->input('periods_id');
        if ($periodsId) {
            $periods = Period::with(['periodUsers' => function ($query) use ($periodsId) {
                $query->whereIn('period_id', $periodsId)
                    ->where('role', '!=', 'Anggota'); // Filter pengurus (bukan anggota)
            }, 'periodUsers.user', 'periodUsers.memberField'])->whereIn('id', $periodsId)->get();
            return response()->json($periods);
        } else {
            return response()->json(['message' => 'No periods_id provided'], 400);
        }
    }
}
