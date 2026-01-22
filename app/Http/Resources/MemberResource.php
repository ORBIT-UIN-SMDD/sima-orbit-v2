<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'nim' => $this->user->nim,
            'photo' => $this->user->photo,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'role' => $this->role,
            'member_field' => $this->memberField->name ?? null,
            'periods' => $this->user->periodUsers->map(function ($periodUser) {
                return [
                    'period_name' => $periodUser->period->name,
                    'period_slug' => $periodUser->period->slug,
                    'role' => $periodUser->role,
                    'member_field' => $periodUser->memberField->name ?? null,
                ];
            })->toArray(),

        ];
    }
}
