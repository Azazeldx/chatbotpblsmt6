<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\WeatherController;

if (config('general-settings.features.ai', false)) {
    Route::controller(ChatbotController::class)->group(function () {
        Route::post('/api/article/generate', 'generateArticle');
        Route::post('/api/chatbot/send', 'send');
        Route::get('/api/chatbot/sessions', 'getSessions');
        Route::get('/api/chatbot/messages/{id}', 'getMessages');
    });
}

$data = config('general-settings.navigation');

Route::get('', [HomeController::class, 'index'])->name('/');

if ($data['home']) {
    Route::get('/'.$data['home']['slug'], [HomeController::class, 'index'])->name($data['home']['slug']);
}

if ($data['search']) {
    Route::get('/'.$data['search']['slug'], [HomeController::class, 'search'])->name($data['search']['slug']);
}

foreach ($data['nav_items'] as $key => $value) {
    if($value['type'] == 'page') {
        Route::get('/'.$value['page']['slug'], [HomeController::class, 'index'])->name($value['page']['slug']);
    }
}

Route::post('/mail', [HomeController::class, 'mail'])->name('mail');

Route::get('/detail/{category}/{slug}', [HomeController::class, 'detail'])->name('detail');

// Testing routes
if (config('app.debug', false)) {
    Route::get('/test/landing', function () {
        return view('tests.landing');
    })->name('test.landing');

    Route::get('/test/berita', function () {
        return view('tests.berita');
    })->name('berita');

    Route::get('/test/publikasi', function () {
        return view('tests.publikasi');
    })->name('publikasi');

    Route::get('/test/program', function () {
        return view('tests.program');
    })->name('program');

    Route::get('/test/about', function () {
        return view('tests.about');
    })->name('about');

    // Route::get('/test/contact', function () {
    //     return view('tests.contact');
    // })->name('contact');

    Route::get('/test/berita_detail', function () {
        return view('tests.berita_detail');
    })->name('berita_detail');
}

Route::get('/weather/current-jimbaran', [WeatherController::class, 'currentJimbaran']);
