<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // جلب بيانات البروفايل
    public function show()
    {
        $user = auth()->user();
        // لاحظ كيف نستخدم العلاقة 'profile' كأنها حقل عادي
        return response()->json([
            'user' => $user->name,
            'profile' => $user->profile 
        ]);
    }

    // إنشاء أو تحديث البروفايل
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // updateOrCreate: دالة ذكية، إذا وجد بروفايل تعدله، وإذا لم يجد تنشئه
        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'bio' => $request->bio
            ]
        );

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile
        ]);
    }
}