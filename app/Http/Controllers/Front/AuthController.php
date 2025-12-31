<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required|min:6'
        ], [
            'login.required' => 'Email atau username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Login gagal, silahkan coba lagi.');
        }

        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        if (Auth::attempt([$loginType => $request->input('login'), 'password' => $request->input('password')])) {

            return redirect()->intended(route('back.dashboard.index'));
        }

        Alert::error('Error', 'Email atau username dan password salah');
        return redirect()->back()->withInput();
    }

    public function logout()
    {
        Auth::logout();
        Alert::success('Success', 'Anda telah berhasil logout');
        return redirect()->route('front.home');
    }

    public function register()
    {

        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Register',
            'meta' => [
                'title' => 'Register | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa, Register',
                'favicon' => $setting_web->favicon
            ],
        ];
        return view('front.pages.auth.register', $data);
    }

    public function registerStore(Request $request)
    {
        //
    }
}
