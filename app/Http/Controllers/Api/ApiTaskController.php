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
        return response()->json(Auth::user()->tasks()->latest()->get());
    }

    public function store(StoreTaskRequest $request)
    {
        // بمجرد وصولنا هنا، فإن البيانات مفحوصة وسليمة 100%
        
        // استخدام $request->validated() لجلب البيانات التي نجحت في الفحص فقط
        $task = Auth::user()->tasks()->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'data' => $task
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