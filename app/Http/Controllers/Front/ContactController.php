<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Kontak Kami',
            'meta' => [
                'title' => 'Kontak Kami | ' . $setting_web->name,
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
                    'name' => 'Kontak Kami',
                    'link' => route('contact')
                ]
            ],
            'setting_web' => $setting_web,
        ];
        return view('front.pages.contact.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'phone.required' => 'Nomor telepon wajib diisi',
            'subject.required' => 'Subjek wajib diisi',
            'message.required' => 'Pesan wajib diisi',
        ]);

        Inbox::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.'
        ]);
    }
}
