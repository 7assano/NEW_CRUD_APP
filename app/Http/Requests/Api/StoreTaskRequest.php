<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 1. القواعد الأساسية المشتركة (لتجنب التكرار)
        $rules = [
            'title' => 'required|string|min:3|max:20|unique:tasks,title',
            'description' => 'nullable|string|max:100',
            'is_completed' => 'boolean',
            // الإضافة الجديدة هنا: التأكد أن التصنيف موجود
            'category_id' => 'nullable|exists:categories,id',

            'tags' => 'nullable|array', // يجب أن تكون مصفوفة
            'tags.*' => 'exists:tags,id', // كل عنصر في المصفوفة يجب أن يكون ID موجود في جدول الـ tags
        ];

        // 2. إذا كانت البيانات مصفوفة (إضافة مهام جماعية)
        if (is_array($this->all()) && isset($this->all()[0])) {
            $arrayRules = [];
            foreach ($rules as $key => $value) {
                $arrayRules["*.$key"] = $value;
            }
            return $arrayRules;
        }

        // 3. إذا كانت البيانات كائن واحد
        return $rules;
    }
}
