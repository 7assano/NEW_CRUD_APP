<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ إنشاء الوسوم (Tags) أولاً (مشتركة بين الجميع)
        $tags = Tag::factory()->count(10)->create();

        // 2️⃣ إنشاء 5 مستخدمين
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) use ($tags) {

                // 3️⃣ لكل مستخدم: إنشاء 3-5 تصنيفات
                $categories = Category::factory()
                    ->count(rand(3, 5))
                    ->create(['user_id' => $user->id]);

                // 4️⃣ لكل مستخدم: إنشاء 15-25 مهمة
                Task::factory()
                    ->count(rand(15, 25))
                    ->create([
                        'user_id' => $user->id,
                        'category_id' => $categories->random()->id, // تصنيف عشوائي
                    ])
                    ->each(function ($task) use ($tags) {
                        // 5️⃣ ربط كل مهمة بـ 0-3 وسوم عشوائياً
                        $task->tags()->attach(
                            $tags->random(rand(0, 3))->pluck('id')
                        );
                    });
            });

        $this->command->info('✅ تم إنشاء البيانات التجريبية بنجاح!');
    }
}
