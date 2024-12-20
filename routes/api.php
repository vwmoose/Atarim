<?php

use App\Http\Controllers\API\UrlShortenerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'abilities:url:encode,url:decode'])->group(function() {
    Route::get('decode/{code}', [UrlShortenerController::class, 'decodeUrl']);
    Route::post('encode', [UrlShortenerController::class, 'encodeUrl']);
});
