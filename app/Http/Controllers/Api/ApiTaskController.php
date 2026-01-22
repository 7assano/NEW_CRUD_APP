<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\UpdateTaskRequest;

class ApiTaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks()
            ->with(['category', 'tags']) // اجلب التصنيف والوسوم مع كل مهمة
            ->latest()
            ->get();

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request)
    {
        // 1. إنشاء المهمة
        $task = auth()->user()->tasks()->create($request->validated());

        // 2. ربط الوسوم (Pivot Table)
        if ($request->has('tags')) {
            // دالة sync هي الأفضل: تقوم بمزامنة الـ IDs في جدول الوصل تلقائياً
            $task->tags()->sync($request->tags);
        }

        return response()->json([
            'message' => 'Task created with tags!',
            // نستخدم load('tags') لكي تظهر الوسوم في الرد فوراً
            'data' => $task->load('tags')
        ], 201);
    }

    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) return response()->json(['message' => 'Unauthorized'], 403);
        return response()->json($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());

        return response()->json([
            'message' => 'تم التعديل بنجاح',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) return response()->json(['message' => 'Unauthorized'], 403);
        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }

    public function toggle(Task $task)
    {
        if ($task->user_id !== Auth::id()) return response()->json(['message' => 'Unauthorized'], 403);
        $task->is_completed = !$task->is_completed;
        $task->save();
        return response()->json($task);
    }
}
