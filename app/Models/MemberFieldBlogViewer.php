<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberFieldBlogViewer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function blog()
    {
        return $this->belongsTo(MemberFieldBlog::class, 'member_field_blog_id');
    }
}
