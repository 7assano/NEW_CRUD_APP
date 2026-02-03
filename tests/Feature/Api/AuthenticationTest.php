<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_register_with_valid_data()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'token',
                    'user' => ['id', 'name', 'email']
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com'
        ]);
    }

    /** @test */
    public function user_cannot_register_with_invalid_email()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token',
                'user' => ['id', 'name', 'email']
            ]);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'بيانات الدخول غير صحيحة',
            ]);
    }

    public function test_user_can_upload_avatar_via_api()
    {
        // 1. تجهيز بيئة الاختبار (وهمي)
        Storage::fake('public'); // محاكاة وحدة التخزين لعدم ملء جهازك بصور حقيقية
        $user = User::factory()->create();
        $token = $user->createToken('test-token')->plainTextToken;

        // 2. تنفيذ الطلب (هذا هو الكود الذي سألت عنه)
        $response = $this->withToken($token)
            ->postJson('/api/v1/profile/avatar', [
                'avatar' => UploadedFile::fake()->image('avatar.jpg')
            ]);

        // 3. التأكد من النتيجة (Assertions)
        $response->assertStatus(200); // التأكد أن السيرفر رد بنجاح
        $this->assertNotNull($user->fresh()->avatar); // التأكد أن قاعدة البيانات تحدثت
        $avatarPath = $user->fresh()->avatar;
        $this->assertTrue(Storage::disk('public')->exists($avatarPath));
    }
}
