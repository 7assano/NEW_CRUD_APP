<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource; // 👈 أضف هذا السطر

class TaskController extends Controller
{
    // عرض كل المهام
    public function index()
    {
        $tasks = auth()->user()->tasks;

        // 👇 استخدم TaskResource::collection للمجموعات
        return TaskResource::collection($tasks);
    }

    // عرض مهمة واحدة
    public function show($id)
    {
        $task = Task::findOrFail($id);

        // التأكد من أن المهمة تخص المستخدم الحالي
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // 👇 استخدم TaskResource للعنصر الواحد
        return new TaskResource($task);
    }

    // إنشاء مهمة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
        ]);

        $task = auth()->user()->tasks()->create($request->all());

        // 👇 استخدم TaskResource
        return new TaskResource($task);
    }

    // تحديث مهمة
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
        ]);

        $task->update($request->all());

        // 👇 استخدم TaskResource
        return new TaskResource($task);
    }

    // حذف مهمة (لا يحتاج Resource)
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
