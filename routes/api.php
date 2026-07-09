<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\HomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is working!',
        'time' => now()->toDateTimeString()
    ]);
});

Route::get('/weather', [WeatherController::class, 'getWeatherData']);
Route::get('/home', [HomeController::class, 'index']); // Example for HomeController


Route::controller(App\Http\Controllers\ChatbotController::class)->group(function () {
    // Batasi endpoint publik agar tidak di-spam (cegah abuse & biaya Gemini membengkak).
    Route::post('/chatbot/public/send', 'sendPublic')
        ->middleware('throttle:20,1')
        ->name('api.chatbot.public.send');
    Route::post('/chatbot/send', 'send');
    Route::get('/chatbot/sessions', 'getSessions');
    Route::get('/chatbot/messages/{id}', 'getMessages');
});
