<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\News;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Home',
            'meta' => [
                'title' => 'Home | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],
            'list_news' => News::latest()->where('status', 'published')->limit(10)->get(),
            //  'welcome_speech' => WelcomeSpeech::first(),
            'list_announcement' => Announcement::latest()->where('is_active', true)->limit(8)->get(),
            'list_event' => Event::latest()->where('is_active', true)->where('access', 'terbuka')->limit(8)->get(),
        ];
        return view('front.pages.home.index', $data);
    }
}
