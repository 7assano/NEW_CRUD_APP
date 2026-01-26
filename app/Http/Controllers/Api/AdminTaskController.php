<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;


class AdminTaskController extends Controller
{
    // عرض كل المهام لجميع المستخدمين
    public function index()
    {
        $tasks = Task::with(['user', 'category', 'tags'])
            ->latest()
            ->paginate(15);

        return TaskResource::collection($tasks);
    }

    // إحصائيات شاملة
    public function statistics()
    {
        $stats = [
            'total_tasks' => Task::count(),
            'completed_tasks' => Task::where('is_completed', true)->count(),
            'pending_tasks' => Task::where('is_completed', false)->count(),
            'high_priority_tasks' => Task::where('priority', 'high')->count(),
            'total_users' => \App\Models\User::count(),
            'tasks_by_priority' => [
                'low' => Task::where('priority', 'low')->count(),
                'medium' => Task::where('priority', 'medium')->count(),
                'high' => Task::where('priority', 'high')->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    // حذف أي مهمة (للـ Admin)
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully by admin'
        ]);
    }

    /**
     * عرض كل المهام المحذوفة (Admin فقط)
     */
    public function trash(Request $request)
    {
        $query = Task::onlyTrashed()
            ->with(['category', 'tags', 'user']);

        $tasks = $query->paginate(15);

        return TaskResource::collection($tasks);
    }

    /**
     * استرجاع أي مهمة محذوفة (Admin فقط)
     */
    public function restore($id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);

        $task->restore();

        return response()->json([
            'success' => true,
            'message' => 'تم استرجاع المهمة بنجاح',
            'data' => new TaskResource($task),
        ]);
    }
}
