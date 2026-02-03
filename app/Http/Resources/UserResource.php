<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'bio'   => $this->profile->bio ?? null,   // جلب الـ bio من العلاقة
            'phone' => $this->profile->phone ?? null, // جلب الـ phone من العلاقة
            'avatar' => $this->avatar,
            'avatar_url' => $this->avatar_url,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'member_since' => $this->created_at->diffForHumans(),
        ];
    }
}
