<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsViewer;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NewsComment;
use App\Models\SettingWebsite;

class NewsController extends Controller
{
    public function index()
    {

        $search = request()->input('q');
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Berita',
            'meta' => [
                'title' => 'Berita | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],

            'page_heading' => 'Semua Berita',
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Berita',
                    'link' => route('news.index')
                ],
            ],
            'category' => '',

            'list_news' => News::latest()
                ->with(['category', 'user', 'viewers', 'comments'])
                ->where('status', 'published')->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%');
                })->paginate(6),
            'setting_web' => $setting_web,
        ];
        return view('front.pages.news.index', $data);
    }

    public function show($slug)
    {
        $setting_web = SettingWebsite::first();

        $news = News::where('slug', $slug)->firstOrFail();
        $data = [

            'title' => $news->title ,
            'meta' => [
                'title' => $news->title . " | " . $setting_web->name,
                'description' => $news->meta_description ? $news->meta_description : strip_tags(substr($news->content, 0, 160)),
                'keywords' => $news->meta_keywords ? $news->meta_keywords : $setting_web->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],
            'setting_web' => $setting_web,

            'category' => '',

            'news' => $news,
            'related_news' => News::latest()
                ->with(['category', 'user', 'viewers', 'comments'])
                ->where('status', 'published')
                ->where('news_category_id', $news->news_category_id)
                ->where('id', '!=', $news->id)
                ->limit(3)
                ->get(),
            'comments' => $news->comments()->where('status', 'approved')->get(),
            'next_news' => News::where('id', '>', $news->id)->first(),
            'prev_news' => News::where('id', '<', $news->id)->first(),
            'setting_web' => $setting_web,
        ];



        $currentUserInfo = Location::get(request()->ip());
        $news_viewers = new NewsViewer();
        $news_viewers->news_id = $news->id;
        $news_viewers->ip = request()->ip();
        if ($currentUserInfo) {
            $news_viewers->country = $currentUserInfo->countryName;
            $news_viewers->city = $currentUserInfo->cityName;
            $news_viewers->region = $currentUserInfo->regionName;
            $news_viewers->postal_code = $currentUserInfo->postalCode;
            $news_viewers->latitude = $currentUserInfo->latitude;
            $news_viewers->longitude = $currentUserInfo->longitude;
            $news_viewers->timezone = $currentUserInfo->timezone;
        }
        $news_viewers->user_agent = Agent::getUserAgent();
        $news_viewers->platform = Agent::platform();
        $news_viewers->browser = Agent::browser();
        $news_viewers->device = Agent::device();
        $news_viewers->save();


        return view('front.pages.news.detail', $data);
    }

    public function category($slug)
    {
        $category = NewsCategory::where('slug', $slug)->firstOrFail();
        $data = [
            'title' => 'Kategori Berita: ' . $category->name,
            'meta' => [
                'title' => 'Kategori Berita: ' . $category->name . ' | ' . SettingWebsite::first()->name,
                'description' => $category->description ? $category->description : 'Kategori Berita: ' . $category->name . ' di ' . SettingWebsite::first()->name,
                'keywords' => SettingWebsite::first()->name . ', ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => SettingWebsite::first()->favicon
            ],

            'page_heading' => 'Ketegori Berita: ' . $category->name,
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Berita',
                    'link' => route('news.index')
                ],
                [
                    'name' => 'Kategori: ' . $category->name,
                    'link' => ''
                ],
            ],

            'category' => $category,
            'list_news' => News::latest()
                ->with(['category', 'user', 'viewers', 'comments'])
                ->where('status', 'published')
                ->where('news_category_id', $category->id)
                ->paginate(6),
                'setting_web' => SettingWebsite::first(),
        ];
        return view('front.pages.news.index', $data);
    }

    public function comment(Request $request, $slug)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'comment' => 'required',
            ], [
                'comment.required' => 'Komentar harus diisi',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator);
            }
        } else {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'comment' => 'required',
            ], [
                'name.required' => 'Nama harus diisi',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Email tidak valid',
                'comment.required' => 'Komentar harus diisi',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->all());
                return redirect()->back()->withInput()->withErrors($validator);
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'comment.required' => 'Komentar harus diisi',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $news = News::where('slug', $slug)->firstOrFail();

        $comment = new NewsComment();
        $comment->news_id = $news->id;
        // if (Auth::check()) {
        //     $comment->user_id = Auth::user()->id;
        //     $comment->name = Auth::user()->name;
        //     $comment->email = Auth::user()->email;
        // } else {
        //     $comment->name = $request->name;
        //     $comment->email = $request->email;
        // }

        $comment->name = $request->name;
        $comment->email = $request->email;

        $comment->comment = $request->comment;
        $comment->save();

        Alert::success('Success', 'Komentar berhasil di posting');
        return redirect()->back();
    }
}
