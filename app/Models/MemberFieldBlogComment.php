<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MemberFieldBlogComment extends Model
{
    use LogsActivity, SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function blog()
    {
        return $this->belongsTo(MemberFieldBlog::class, 'member_field_blog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(MemberFieldBlogComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(MemberFieldBlogComment::class, 'parent_id');
    }
}
