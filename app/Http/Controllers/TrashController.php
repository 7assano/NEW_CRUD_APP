<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    public function index()
    {
        $trashedTasks = Auth::user()->tasks()->onlyTrashed()->with('category')->latest()->get();
        return view('trash.index', compact('trashedTasks'));
    }

    public function restore($id)
    {
        $task = Auth::user()->tasks()->onlyTrashed()->findOrFail($id);
        $task->restore();

        return redirect()->route('trash.index')->with('success', 'Task restored successfully!');
    }

    public function forceDelete($id)
    {
        $task = Auth::user()->tasks()->onlyTrashed()->findOrFail($id);

        // حذف الصورة إذا كانت موجودة
        if ($task->image) {
            Storage::disk('public')->delete($task->image);
        }

        $task->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Task permanently deleted!');
    }

    public function empty()
    {
        $tasks = Auth::user()->tasks()->onlyTrashed()->get();

        // حذف كل الصور
        foreach ($tasks as $task) {
            if ($task->image) {
                Storage::disk('public')->delete($task->image);
            }
        }

        // حذف نهائي لكل المهام المحذوفة
        Auth::user()->tasks()->onlyTrashed()->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Trash emptied successfully!');
    }
}
