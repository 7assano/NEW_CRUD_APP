<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مصرحاً له بالقيام بهذا الطلب.
     */
    public function authorize(): bool
    {
        // نغيرها لـ true لأننا نعتمد على Middleware 'auth:sanctum' في الروابط أصلاً
        return true;
    }

    /**
     * الحصول على قواعد التحقق (Validation Rules) التي تنطبق على الطلب.
     */
    public function rules(): array
{
    // إذا كانت البيانات مصفوفة
    if (is_array($this->all()) && isset($this->all()[0])) {
        return [
            '*.title' => 'required|string|min:3|max:20|unique:tasks,title',
            '*.description' => 'nullable|string|max:100',
            '*.is_completed' => 'boolean',
        ];
    }

    // إذا كانت البيانات كائن واحد
    return [
        'title' => 'required|string|min:3|max:20|unique:tasks,title',
        'description' => 'nullable|string|max:100',
        'is_completed' => 'boolean',
    ];
}
} 