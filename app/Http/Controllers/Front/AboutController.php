<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\MemberField;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Tentang Kami',
            'meta' => [
                'title' => 'Tentang Kami | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],
             'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Tentang Kami',
                    'link' => route('about')
                ]
            ],
            'setting_web' => $setting_web,
            'about_first' => AboutUs::first(),
            'about_other' => AboutUs::skip(1)->take(PHP_INT_MAX)->get(),

            'count_member_field' => MemberField::count(),
            'count_user_member_active' => 100,
            'count_user_member_admin' => 10,
            'count_user_member_alumnus' => 50,
        ];
        return view('front.pages.about.index', $data);
    }
}
