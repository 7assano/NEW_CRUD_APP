<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    // عرض معلوم��ت المستخدم
    public function show()
    {
        $user = auth()->user();
        $user->load('profile');

        return new UserResource($user);
    }

    // تحديث البروفايل
    public function store(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['bio', 'phone', 'address'])
        );

        $user->load('profile');

        return new UserResource($user);
    }

    // 👇 دالة جديدة: رفع صورة البروفايل
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // حجم أقصى 2MB
        ]);

        $user = auth()->user();

        // حذف الصورة القديمة إذا كانت موجودة
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // حفظ الصورة الجديدة
        $path = $request->file('avatar')->store('avatars', 'public');

        // تحديث المستخدم
        $user->update(['avatar' => $path]);

        return new UserResource($user);
    }

    // 👇 دالة جديدة: حذف صورة البروفايل
    public function deleteAvatar()
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Avatar deleted successfully'
        ]);
    }

    public function update(Request $request)
{
    // كود التحديث الخاص بك هنا...
    
    $user = $request->user();
    $user->load('profile'); // 👈 هذه الخطوة السحرية لجلب البيانات الجديدة

    return new UserResource($user);
}
    
}


