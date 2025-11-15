<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Heart Care API",
 *     version="1.0.0",
 *     description="API documentation for Heart Care application - Patient mobile app endpoints",
 *     @OA\Contact(
 *         email="support@heartcare.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Local API Server"
 * )
 *
 * @OA\Server(
 *     url="https://api.heartcare.com",
 *     description="Production API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter your bearer token in the format: Bearer {token}"
 * )
 *
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     title="Patient",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="full_name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="mobile_number", type="string", example="+1234567890"),
 *     @OA\Property(property="hospital_id", type="string", example="HOSP001"),
 *     @OA\Property(property="profile_image", type="string", nullable=true, example="http://example.com/storage/patients/image.jpg"),
 *     @OA\Property(property="country", type="string", nullable=true, example="Egypt"),
 *     @OA\Property(property="city", type="string", nullable=true, example="Cairo"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", nullable=true, example="1990-01-01"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, nullable=true, example="male"),
 *     @OA\Property(property="age", type="integer", nullable=true, example=35),
 *     @OA\Property(property="weight", type="number", format="float", nullable=true, example=75.5),
 *     @OA\Property(property="height", type="number", format="float", nullable=true, example=175.0),
 *     @OA\Property(property="bmi", type="number", format="float", nullable=true, example=24.5),
 *     @OA\Property(property="email_verified", type="boolean", example=false),
 *     @OA\Property(property="mobile_verified", type="boolean", example=false),
 *     @OA\Property(property="profile_completion_percentage", type="integer", example=65),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01 12:00:00"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01 12:00:00")
 * )
 */
class Controller extends BaseController
{
    //
}

