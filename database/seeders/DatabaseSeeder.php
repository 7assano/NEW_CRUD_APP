<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // استدعاء الـ Seeder الخاص بنا
        $this->call([
            DemoDataSeeder::class,
        ]);
    }
}
