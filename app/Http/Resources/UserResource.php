<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'nim' => $this->nim,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'gender' => $this->gender,
            'gender_label' => $this->gender === 'L' ? 'Laki-laki' : ($this->gender === 'P' ? 'Perempuan' : null),
            'job' => $this->job,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'bio' => $this->bio,
            'blood_type' => $this->blood_type,
            'photo' => $this->photo,
            'photo_url' => $this->getPhoto(),
            'is_active' => $this->is_active,
            'department' => $this->whenLoaded('department', function () {
                return $this->department->name;
            }),
            'faculty' => $this->whenLoaded('department', function () {
                return $this->department->faculty ? $this->department->faculty->name : null;
            }),
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name');
            }),
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->permissions->pluck('name');
            }),
            'periods' => $this->periodUsers->map(function ($periodUser) {
                return [
                    'period_name' => $periodUser->period->name,
                    'period_slug' => $periodUser->period->slug,
                    'role' => $periodUser->role,
                    'member_field' => $periodUser->memberField->name ?? null,
                ];
            })->toArray(),
            'email_verified_at' => $this->email_verified_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
