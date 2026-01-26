<?php

namespace App\Http\Controllers;

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Task Management API",
 *         description="Complete API Documentation"
 *     ),
 *     @OA\Server(
 *         url="http://127.0.0.1:8000/api/v1",
 *         description="Local Server"
 *     ),
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer"
 *     )
 * )
 */
class OpenApiSpec {}
