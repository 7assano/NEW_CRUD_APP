<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // عرض معلومات المستخدم
    public function show()
{
    // الحصول على المستخدم الحالي مع بيانات ملفه الشخصي المرتبطة به
    $user = Auth::user();
    if ($user instanceof \Illuminate\Database\Eloquent\Model) {
        $user->load('profile');
    }

    // إرجاع ملف العرض وتمرير بيانات المستخدم له
    return view('profile.show', compact('user'));
}

    // تحديث البروفايل
    public function store(Request $request)
    {
        $request->validate([
            'bio' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only(['bio', 'phone', 'address'])
        );

        $user->load('profile');

        return back()->with('success', 'تم تحديث بيانات ملفك الشخصي بنجاح!');
    }

    // رفع صورة البروفايل
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

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

    // حذف صورة البروفايل
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Avatar deleted successfully'
        ]);
    }
}
