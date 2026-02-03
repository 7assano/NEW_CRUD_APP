<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use App\Services\TaskFilterService;
use Illuminate\Support\Facades\Http;

class ApiTaskController extends Controller
{
    // عرض كل المهام مع الفلترة والترتيب
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()
            ->with(['category', 'tags', 'user']);

        // 🔍 فلترة حسب الأولوية
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // ⭐ فلترة المفضلة فقط
        if ($request->boolean('favorites')) {
            $query->where('is_favorite', true);
        }

        // ✅ فلترة حسب الحالة
        if ($request->has('completed')) {
            if ($request->has('completed')) {
    $query->where('is_completed', $request->boolean('completed'));
} else {
                $query->pending();
            }
        }

        // 🏷️ فلترة حسب الـ Category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 🏷️ فلترة حسب الـ Tag
        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag_id);
            });
        }

        // 🔎 البحث في العنوان والوصف
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 📊 الترتيب
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        // ترتيب خاص للأولوية
        if ($sortBy === 'priority') {
            $query->orderByRaw("
            CASE priority 
                WHEN 'high' THEN 1 
                WHEN 'medium' THEN 2 
                WHEN 'low' THEN 3 
            END
        ");
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $tasks = $query->paginate(15); // 👈 تغيير من get() إلى paginate()

        return TaskResource::collection($tasks);
    }

    // عرض مهمة واحدة
    public function show(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->load(['category', 'tags', 'user']);

        return new TaskResource($task);
    }

    // إنشاء مهمة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'nullable|in:low,medium,high',      // 👈 جديد
            'is_favorite' => 'nullable|boolean',              // 👈 جديد
        ]);

        $task = auth()->user()->tasks()->create($request->all());
        $task->load(['category', 'tags', 'user']);

        return new TaskResource($task);
    }

    // تحديث مهمة
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'priority' => 'nullable|in:low,medium,high',      // 👈 جديد
            'is_favorite' => 'nullable|boolean',              // 👈 جديد
        ]);

        $task->update($request->all());
        $task->load(['category', 'tags', 'user']);

        return new TaskResource($task);
    }

    // حذف مهمة
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully'
        ]);
    }

    // Toggle الحالة
    public function toggle(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->is_completed = !$task->is_completed;
        $task->save();
        $task->load(['category', 'tags', 'user']);

        return new TaskResource($task);
    }

    // 👇 دالة جديدة: Toggle المفضلة
    public function toggleFavorite(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->is_favorite = !$task->is_favorite;
        $task->save();
        $task->load(['category', 'tags', 'user']);

        return new TaskResource($task);
    }

    /**
     * عرض المهام المحذوفة (Trash)
     */
    public function trash(Request $request)
    {
        $query = auth()->user()->tasks()
            ->onlyTrashed() // فقط المهام المحذوفة
            ->with(['category', 'tags']);

        $tasks = $query->paginate(15);

        return TaskResource::collection($tasks);
    }

    /**
     * استرجاع مهمة محذوفة
     */
    public function restore($id)
    {
        $task = auth()->user()->tasks()
            ->onlyTrashed()
            ->findOrFail($id);

        $task->restore();

        return response()->json([
            'success' => true,
            'message' => 'تم استرجاع المهمة بنجاح',
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * حذف نهائي (Force Delete)
     */
    public function forceDelete($id)
    {
        $task = auth()->user()->tasks()
            ->onlyTrashed()
            ->findOrFail($id);

        $task->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المهمة نهائياً',
        ]);
    }

    /**
     * تفريغ سلة المهملات (حذف كل المهام المحذوفة)
     */
    public function emptyTrash()
    {
        $deletedCount = auth()->user()->tasks()
            ->onlyTrashed()
            ->forceDelete();

        return response()->json([
            'success' => true,
            'message' => "تم حذف {$deletedCount} مهمة نهائياً",
        ]);
    }



public function testApiCall()
{
    $token = "4|vBTgp5JmvYTsDov5GhUzKISgAPq72fNwSn6YFsUI92222d2d";
    
    $response = Http::withToken($token)
        ->withHeaders([
            'Accept' => 'application/json',
        ])
        ->post('http://127.0.0.1:8000/api/v1/tasks', [
            'title' => 'مهمة تدريبية جديدة',
            'description' => 'تم إنشاؤها باستخدام Laravel HTTP Client محاكاة لـ cURL',
            'priority' => 'high',
        ]);

    return $response->json();
}

}
