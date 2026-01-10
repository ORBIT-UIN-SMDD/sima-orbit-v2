<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MemberFieldBlog extends Model
{
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function memberField()
    {
        return $this->belongsTo(MemberField::class, 'member_field_id');
    }

    public function comments()
    {
        return $this->hasMany(MemberFieldBlogComment::class, 'member_field_blog_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function viewers()
    {
        return $this->hasMany(MemberFieldBlogViewer::class, 'member_field_blog_id');
    }

    public function getThumbnail()
    {
        if ($this->thumbnail && (str_starts_with($this->thumbnail, 'http://') || str_starts_with($this->thumbnail, 'https://'))) {
            return $this->thumbnail;
        }
        return $this->thumbnail ? Storage::url($this->thumbnail) : 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg';
    }
}

