<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MemberField;
use App\Models\MemberFieldBlog;
use App\Models\MemberFieldBlogComment;
use App\Models\MemberFieldBlogViewer;
use App\Models\SettingWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Facades\Agent;
use RealRashid\SweetAlert\Facades\Alert;
use Stevebauman\Location\Facades\Location;

class MemberFieldBlogController extends Controller
{
    public function index()
    {
        $search = request()->input('q');
        $setting_web = SettingWebsite::first();
        $data = [
            'title' => 'Blog Bidang',
            'meta' => [
                'title' => 'Blog Bidang | ' . $setting_web->name,
                'description' => strip_tags($setting_web->about),
                'keywords' => $setting_web->name . ', Blog Bidang, ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],

            'page_heading' => 'Semua Blog Bidang',
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Blog Bidang',
                    'link' => route('memberfield.index')
                ],
            ],
            'member_field' => '',

            'list_blog' => MemberFieldBlog::latest()
                ->with(['memberField', 'period', 'user', 'viewers', 'comments'])
                ->where('status', 'published')
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%');
                })->paginate(6),
            'setting_web' => $setting_web,
        ];
        return view('front.pages.member_field.index', $data);
    }

    public function show($slug)
    {
        $setting_web = SettingWebsite::first();

        $blog = MemberFieldBlog::where('slug', $slug)->firstOrFail();
        $data = [
            'title' => $blog->title,
            'meta' => [
                'title' => $blog->title . " | " . $setting_web->name,
                'description' => $blog->meta_description ? $blog->meta_description : strip_tags(substr($blog->content, 0, 160)),
                'keywords' => $blog->meta_keywords ? $blog->meta_keywords : $setting_web->name . ', Blog Bidang, ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],
            'setting_web' => $setting_web,

            'member_field' => '',

            'blog' => $blog,
            'related_blogs' => MemberFieldBlog::latest()
                ->with(['memberField', 'user', 'viewers', 'comments'])
                ->where('status', 'published')
                ->where('member_field_id', $blog->member_field_id)
                ->where('id', '!=', $blog->id)
                ->limit(3)
                ->get(),
            'comments' => $blog->comments()->where('status', 'approved')->get(),
            'next_blog' => MemberFieldBlog::where('id', '>', $blog->id)->first(),
            'prev_blog' => MemberFieldBlog::where('id', '<', $blog->id)->first(),
        ];

        // Record viewer
        $currentUserInfo = Location::get(request()->ip());
        $viewer = new MemberFieldBlogViewer();
        $viewer->member_field_blog_id = $blog->id;
        $viewer->ip = request()->ip();
        if ($currentUserInfo) {
            $viewer->country = $currentUserInfo->countryName;
            $viewer->city = $currentUserInfo->cityName;
            $viewer->region = $currentUserInfo->regionName;
            $viewer->postal_code = $currentUserInfo->postalCode;
            $viewer->latitude = $currentUserInfo->latitude;
            $viewer->longitude = $currentUserInfo->longitude;
            $viewer->timezone = $currentUserInfo->timezone;
        }
        $viewer->user_agent = Agent::getUserAgent();
        $viewer->platform = Agent::platform();
        $viewer->browser = Agent::browser();
        $viewer->device = Agent::device();
        $viewer->save();

        return view('front.pages.member_field.detail', $data);
    }

    public function division($slug)
    {
        $memberField = MemberField::where('slug', $slug)->firstOrFail();
        $search = request()->input('q');
        $setting_web = SettingWebsite::first();

        $data = [
            'title' => 'Blog Bidang: ' . $memberField->name,
            'meta' => [
                'title' => 'Blog Bidang: ' . $memberField->name . ' | ' . $setting_web->name,
                'description' => $memberField->description ? strip_tags($memberField->description) : 'Blog Bidang: ' . $memberField->name . ' di ' . $setting_web->name,
                'keywords' => $setting_web->name . ', ' . $memberField->name . ', Blog Bidang, ORBIT, SIMA ORBIT, UIN Sjech M. Djamil Djambek Bukittinggi, UIN Bukittinggi, UKM ORBIT, ORBIT UIN Bukittinggi, Unit Kegiatan Mahasiswa',
                'favicon' => $setting_web->favicon
            ],

            'page_heading' => 'Blog Bidang: ' . $memberField->name,
            'breadcrumbs' => [
                [
                    'name' => 'Home',
                    'link' => route('home')
                ],
                [
                    'name' => 'Blog Bidang',
                    'link' => route('memberfield.index')
                ],
                [
                    'name' => $memberField->name,
                    'link' => ''
                ],
            ],

            'member_field' => $memberField,
            'list_blog' => MemberFieldBlog::latest()
                ->with(['memberField', 'period', 'user', 'viewers', 'comments'])
                ->where('status', 'published')
                ->where('member_field_id', $memberField->id)
                ->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('content', 'like', '%' . $search . '%');
                })
                ->paginate(6),
            'setting_web' => $setting_web,
        ];
        return view('front.pages.member_field.index', $data);
    }

    public function comment(Request $request, $slug)
    {
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

        $blog = MemberFieldBlog::where('slug', $slug)->firstOrFail();

        $comment = new MemberFieldBlogComment();
        $comment->member_field_blog_id = $blog->id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->save();

        Alert::success('Success', 'Komentar berhasil di posting');
        return redirect()->back();
    }
}
