<?php

namespace App\Http\Controllers;


use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // 1. عرض قائمة المهام (Read)
public function index(Request $request) // أضفنا Request هنا
{
    /** @var User $user */
    $user = Auth::user();
    
    // 1. نبدأ الاستعلام بمهام المستخدم الحالي
    $query = $user->tasks();

    // 2. البحث (Search)
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // 3. الفلترة (Filter)
    if ($request->has('filter')) {
        if ($request->filter == 'completed') {
            $query->where('is_completed', true);
        } elseif ($request->filter == 'pending') {
            $query->where('is_completed', false);
        }
    }

    // 4. جلب النتائج النهائية
    $tasks = $query->latest()->get();

    return view('tasks.index', compact('tasks'));
}

    // 2. عرض صفحة إضافة مهمة (Create Form)
    public function create()
    {
        return view('tasks.create');
    }

    // 3. حفظ المهمة في قاعدة البيانات (Store)
public function store(Request $request)
{
    $request->validate(['title' => 'required|min:3']);

    /** @var User $user */
    $user = Auth::user();
    
    // إنشاء المهمة مرتبطة بالمستخدم الحالي
    $user->tasks()->create([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
}
// 1. عرض صفحة التعديل مع بيانات المهمة الحالية
// 1. عرض صفحة التعديل (فقط إذا كانت المهمة تخص المستخدم)
public function edit(Task $task)
{
    if ($task->user_id !== Auth::id()) {
        abort(403, "You cannot edit a task that does not belong to you!");
    }
    return view('tasks.edit', compact('task'));
}

public function update(Request $request, Task $task)            
{
    $request->validate(['title' => 'required|min:3']);
    if ($task->user_id !== Auth::id()) {
        abort(403, "You cannot update a task that does not belong to you!");
    }
    $task->update([
        'title' => $request->title,
        'description' => $request->description,
        'is_completed' => $request->has('is_completed'),
    ]);
    return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
}

public function destroy(Task $task)
{
    if ($task->user_id !== Auth::id()) {
        abort(403, "You cannot delete a task that does not belong to you!");
    }
    $task->delete();
    return redirect()->back()->with('success', 'Task deleted successfully!');
}

public function toggle(Task $task)
{
    if ($task->user_id !== Auth::id()) {
        abort(403, "You cannot change the status of a task that does not belong to you!");
    }
    $task->is_completed = !$task->is_completed;
    $task->save();
    return redirect()->back()->with('success', 'Task status changed successfully!');
}

}