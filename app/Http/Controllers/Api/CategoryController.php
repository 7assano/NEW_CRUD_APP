<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // جلب كل التصنيفات مع المهام التابعة لها
    public function index()
    {
        // استخدام with('tasks') لجلب المهام مع كل تصنيف (Eager Loading)
        return response()->json(auth()->user()->categories()->with('tasks')->get());
    }

    // إنشاء تصنيف جديد
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50']);

        $category = auth()->user()->categories()->create([
            'name' => $request->name
        ]);

        return response()->json($category, 201);
    }
}