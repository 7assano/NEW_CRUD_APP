<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class TaskFilterService
{
    public static function apply(Builder $query, array $filters)
    {
        // Search في العنوان والوصف
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filter بالأولوية
        if (isset($filters['priority']) && !empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        // Filter بالحالة (مكتملة أم لا)
        if (isset($filters['completed'])) {
            $isCompleted = filter_var($filters['completed'], FILTER_VALIDATE_BOOLEAN);
            $query->where('is_completed', $isCompleted);
        }

        // Filter بالمفضلة
        if (isset($filters['favorite'])) {
            $isFavorite = filter_var($filters['favorite'], FILTER_VALIDATE_BOOLEAN);
            $query->where('is_favorite', $isFavorite);
        }

        // Filter بالـ Category
        if (isset($filters['category_id']) && !empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Sort (الترتيب)
        if (isset($filters['sort_by']) && !empty($filters['sort_by'])) {
            $sortBy = $filters['sort_by'];
            $sortOrder = $filters['sort_order'] ?? 'desc'; // default: desc

            $query->orderBy($sortBy, $sortOrder);
        } else {
            // Default: الأحدث أولاً
            $query->latest();
        }

        return $query;
    }
}
