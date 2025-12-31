<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsViewer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
