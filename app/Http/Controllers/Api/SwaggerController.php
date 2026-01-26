<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="Task Management API",
 *     version="1.0.0",
 *     description="API Documentation for Task Management System with Authentication, CRUD Operations, Search, Filter, and Admin Features",
 *     @OA\Contact(
 *         email="support@taskmanager.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api/v1",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your Bearer token in the format: Bearer {token}"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Authentication"
 * )
 *
 * @OA\Tag(
 *     name="Tasks",
 *     description="API Endpoints for Task Management"
 * )
 *
 * @OA\Tag(
 *     name="Trash",
 *     description="API Endpoints for Soft Delete (Trash Management)"
 * )
 *
 * @OA\Tag(
 *     name="Categories",
 *     description="API Endpoints for Categories"
 * )
 *
 * @OA\Tag(
 *     name="Profile",
 *     description="API Endpoints for User Profile"
 * )
 *
 * @OA\Tag(
 *     name="Admin",
 *     description="API Endpoints for Admin Operations"
 * )
 */
class SwaggerController extends Controller
{
    // هذا Controller فقط للـ Documentation
}
