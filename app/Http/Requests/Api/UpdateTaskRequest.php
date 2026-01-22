<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
{
    return true;
}

public function rules(): array
{
    return [
        // لاحظ استخدمنا 'sometimes' بدلاً من 'required'
        // تعني: "إذا أرسلت العنوان افحصه، وإذا لم ترسله فلا بأس"
        'title' => 'sometimes|string|min:3|max:20|unique:tasks,title,' . $this->route('task')->id,
        'description' => 'nullable|string|max:100',
        'is_completed' => 'boolean',
    ];
}
}
