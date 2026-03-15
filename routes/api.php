<?php

use App\Http\Controllers\Api\SpmiPublicApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('v1')->middleware(['throttle:spmi-api'])->group(function () {
    // Public Info (Tanpa Auth jika diizinkan kampus)
    Route::get('/quality-stats', [SpmiPublicApiController::class, 'getQualityStats']);
    Route::prefix('edom')->group(function () {
        Route::get('/my-krs', [EdomApiController::class, 'getMyKrs']);
        Route::get('/questions', [EdomApiController::class, 'getQuestions']);
        Route::post('/submit', [EdomApiController::class, 'submitEdom']);
    });
    // Protected Info (Butuh Token Sanctum/SIAKAD)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/accreditation/student-satisfaction', [SpmiPublicApiController::class, 'getAccreditationStats']);
        Route::get('/lecturer-edom/{siakad_lecturer_id}', [SpmiPublicApiController::class, 'getLecturerEdomScore']);
    });
});
