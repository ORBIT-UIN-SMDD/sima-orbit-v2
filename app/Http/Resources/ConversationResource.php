<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'description' => $this->description,
            'type' => $this->type,
            'last_message' => $this->latestMessage ? [
                'id' => $this->latestMessage->id,
                'content' => $this->latestMessage->content,
                'sender' => [
                    'id' => $this->latestMessage->sender->id,
                    'nim' => $this->latestMessage->sender->nim,
                    'name' => $this->latestMessage->sender->name,
                ],
                'created_at' => $this->latestMessage->created_at,
            ] : null,
            'users' => $this->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nim' => $user->nim,
                    'name' => $user->name,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
