<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'thumbnail' => $this->getThumbnail(),
            'category' => [
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ],
            'author' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'photo' => $this->user->getPhoto(),
            ],
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords' => $this->meta_keywords,
            'comments' => $this->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'name' => $comment->user ? $comment->user->name : $comment->name,
                    'photo' => $comment->user ? $comment->user->getPhoto() : null,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at,
                ];
            }),
            'view_count' => $this->viewers()->count(),
            'comments_count' => $this->comments()->count(),
            'share' => [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode(url('/news/' . $this->slug)),
                'twitter' => 'https://twitter.com/intent/tweet?url=' . urlencode(url('/news/' . $this->slug)) . '&text=' . urlencode($this->title),
                'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode(url('/news/' . $this->slug)) . '&title=' . urlencode($this->title),
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
