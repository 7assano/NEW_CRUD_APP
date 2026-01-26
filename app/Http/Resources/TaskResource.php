<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_completed' => $this->is_completed,

            // 👇 الحقول الجديدة
            'priority' => $this->priority,
            'is_favorite' => $this->is_favorite,

            // أيقونات للأولوية (اختياري لكن جميل!)
            'priority_icon' => $this->getPriorityIcon(),

            // تنسيق التواريخ
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at->diffForHumans(),

            // Category
            'category' => $this->when($this->category, [
                'id' => $this->category?->id,
                'name' => $this->category?->name,
            ]),

            // Tags
            'tags' => $this->tags->map(function ($tag) {
                return [
                    'id' => $tag->id,
                    'name' => $tag->name,
                ];
            }),

            // Owner
            'owner' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }

    // 👇 دالة مساعدة للأيقونات
    private function getPriorityIcon()
    {
        return match ($this->priority) {
            'high' => '🔴',
            'medium' => '🟡',
            'low' => '🟢',
            default => '⚪',
        };
    }
}
