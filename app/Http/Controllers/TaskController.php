<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $query = $user->tasks()->with('category');

        // البحث
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // الفلترة حسب الحالة
        if ($request->has('filter')) {
            if ($request->filter == 'completed') {
                $query->where('is_completed', true);
            } elseif ($request->filter == 'pending') {
                $query->where('is_completed', false);
            }
        }

        // الفلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // الفلترة حسب المفضلة
        if ($request->has('favorite') && $request->favorite == '1') {
            $query->where('is_favorite', true);
        }

        // الفلترة حسب التصنيف
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $tasks = $query->latest()->get();
        $categories = $user->categories;

        return view('tasks.index', compact('tasks', 'categories'));
    }

    public function create()
    {
        $categories = Auth::user()->categories;
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        /** @var User $user */
        $user = Auth::user();

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
        ];

        // رفع الصورة
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tasks', 'public');
        }

        $user->tasks()->create($data);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully!');
    }

    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, "You cannot edit a task that does not belong to you!");
        }

        $categories = Auth::user()->categories;
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($task->user_id !== Auth::id()) {
            abort(403, "You cannot update a task that does not belong to you!");
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => $request->has('is_completed'),
            'priority' => $request->priority,
            'category_id' => $request->category_id,
        ];

        // رفع الصورة الجديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($task->image) {
                Storage::disk('public')->delete($task->image);
            }
            $data['image'] = $request->file('image')->store('tasks', 'public');
        }

        $task->update($data);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, "You cannot delete a task that does not belong to you!");
        }

        $task->delete(); // Soft Delete
        return redirect()->route('tasks.index')->with('success', 'Task moved to trash!');
    }

    public function toggle(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->is_completed = !$task->is_completed;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task status updated!');
    }

    public function favorite(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->is_favorite = !$task->is_favorite;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Favorite status updated!');
    }
}
