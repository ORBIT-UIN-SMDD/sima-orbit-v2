<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\MemberField;
use App\Models\MemberFieldBlog;
use App\Models\MemberFieldBlogComment;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MemberFieldBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberFieldBlog::with(['memberField', 'user', 'period'])->latest();

        // Filter berdasarkan period_id jika ada
        if ($request->has('period_id') && $request->period_id) {
            $query->where('period_id', $request->period_id);
        }

        // Filter berdasarkan member_field_id jika ada
        if ($request->has('member_field_id') && $request->member_field_id) {
            $query->where('member_field_id', $request->member_field_id);
        }

        $data = [
            'title' => 'Blog Bidang',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Blog Bidang',
                    'link' => route('back.member-field-blog.index')
                ]
            ],
            'blogs' => $query->get(),
            'periods' => Period::orderBy('name', 'desc')->get(),
            'memberFields' => MemberField::all(),
            'filter_period_id' => $request->period_id,
            'filter_member_field_id' => $request->member_field_id
        ];

        return view('back.pages.member_field_blog.index', $data);
    }

    public function create(Request $request)
    {
        $data = [
            'title' => 'Tambah Blog Bidang',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Blog Bidang',
                    'link' => route('back.member-field-blog.index')
                ],
                [
                    'name' => 'Tambah Blog',
                    'link' => route('back.member-field-blog.create')
                ]
            ],
            'memberFields' => MemberField::all(),
            'periods' => Period::orderBy('name', 'desc')->get(),
            'selected_period_id' => $request->period_id,
            'selected_member_field_id' => $request->member_field_id
        ];

        return view('back.pages.member_field_blog.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required|string|max:255',
                'content' => 'required',
                'member_field_id' => 'required|exists:member_fields,id',
                'period_id' => 'nullable|exists:periods,id',
                'status' => 'required|in:draft,published,archived',
                'meta_keywords' => 'nullable',
            ],
            [
                'thumbnail.image' => 'File harus berupa gambar',
                'thumbnail.mimes' => 'Format file harus jpeg, png, jpg, gif, atau svg',
                'thumbnail.max' => 'Ukuran file maksimal 2MB',
                'title.required' => 'Judul harus diisi',
                'content.required' => 'Konten harus diisi',
                'member_field_id.required' => 'Bidang harus dipilih',
                'member_field_id.exists' => 'Bidang tidak valid',
                'status.required' => 'Status harus dipilih',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->all());
        }

        // Generate unique slug
        $slug = Str::slug($request->title);
        if (MemberFieldBlog::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . rand(1000, 9999);
        }

        $blog = new MemberFieldBlog();
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->content = $request->content;
        $blog->member_field_id = $request->member_field_id;
        $blog->period_id = $request->period_id;
        $blog->user_id = Auth::user()->id;
        $blog->status = $request->status;
        $blog->meta_title = $request->title;
        $blog->meta_description = Str::limit(strip_tags($request->content), 150);
        $blog->meta_keywords = $request->meta_keywords ? implode(", ", array_column(json_decode($request->meta_keywords), 'value')) : null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $blog->thumbnail = $thumbnail->storeAs(
                'member-field-blog',
                date('YmdHis') . '_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension(),
                'public'
            );
        }

        $blog->save();

        return redirect()->route('back.member-field-blog.index')->with('success', 'Blog Bidang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $blog = MemberFieldBlog::findOrFail($id);

        $data = [
            'title' => 'Edit Blog Bidang',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Blog Bidang',
                    'link' => route('back.member-field-blog.index')
                ],
                [
                    'name' => 'Edit Blog',
                    'link' => route('back.member-field-blog.edit', $id)
                ]
            ],
            'blog' => $blog,
            'memberFields' => MemberField::all(),
            'periods' => Period::orderBy('name', 'desc')->get()
        ];

        return view('back.pages.member_field_blog.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'title' => 'required|string|max:255',
                'content' => 'required',
                'member_field_id' => 'required|exists:member_fields,id',
                'period_id' => 'nullable|exists:periods,id',
                'status' => 'required|in:draft,published,archived',
                'meta_keywords' => 'nullable',
            ],
            [
                'thumbnail.image' => 'File harus berupa gambar',
                'thumbnail.mimes' => 'Format file harus jpeg, png, jpg, gif, atau svg',
                'thumbnail.max' => 'Ukuran file maksimal 2MB',
                'title.required' => 'Judul harus diisi',
                'content.required' => 'Konten harus diisi',
                'member_field_id.required' => 'Bidang harus dipilih',
                'member_field_id.exists' => 'Bidang tidak valid',
                'status.required' => 'Status harus dipilih',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->all());
        }

        $blog = MemberFieldBlog::findOrFail($id);

        // Generate unique slug if title changed
        $slug = Str::slug($request->title);
        if (MemberFieldBlog::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $slug . '-' . rand(1000, 9999);
        }

        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->content = $request->content;
        $blog->member_field_id = $request->member_field_id;
        $blog->period_id = $request->period_id;
        $blog->user_id = Auth::user()->id;
        $blog->status = $request->status;
        $blog->meta_title = $request->title;
        $blog->meta_description = Str::limit(strip_tags($request->content), 150);
        $blog->meta_keywords = $request->meta_keywords ? implode(", ", array_column(json_decode($request->meta_keywords), 'value')) : null;

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $blog->thumbnail = $thumbnail->storeAs(
                'member-field-blog',
                date('YmdHis') . '_' . Str::slug($request->title) . '.' . $thumbnail->getClientOriginalExtension(),
                'public'
            );
        }

        $blog->save();

        return redirect()->route('back.member-field-blog.index')->with('success', 'Blog Bidang berhasil diubah');
    }

    public function destroy($id)
    {
        $blog = MemberFieldBlog::findOrFail($id);
        $blog->delete();

        return redirect()->back()->with('success', 'Blog Bidang berhasil dihapus');
    }

    public function comment()
    {
        $data = [
            'title' => 'Komentar Blog Bidang',
            'breadcrumbs' => [
                [
                    'name' => 'Dashboard',
                    'link' => route('back.dashboard.index')
                ],
                [
                    'name' => 'Komentar Blog Bidang',
                    'link' => route('back.member-field-blog.comment')
                ]
            ],
            'comments' => MemberFieldBlogComment::with('blog')->get()
        ];

        return view('back.pages.member_field_blog.comment', $data);
    }

    public function commentSpam($id)
    {
        $comment = MemberFieldBlogComment::findOrFail($id);
        $comment->status = 'spam';
        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil ditandai sebagai spam');
    }

    public function commentApprove($id)
    {
        $comment = MemberFieldBlogComment::findOrFail($id);
        $comment->status = 'approved';
        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil disetujui');
    }

    public function commentDestroy($id)
    {
        $comment = MemberFieldBlogComment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus');
    }
}
