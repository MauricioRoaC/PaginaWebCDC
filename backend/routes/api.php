<?php
use App\Http\Controllers\Public\EventApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Public\DocumentApiController;
use App\Http\Controllers\Api\ContactApiController;

// Noticias
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/recent', [NewsController::class, 'recent']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

// Visitas
Route::post('/visits', [VisitController::class, 'store']);

// Contacto - formulario de mensajes
Route::post('/contact/messages', [ContactController::class, 'store']);

Route::get('/events', [EventApiController::class, 'index']);

Route::get('/documents', [DocumentApiController::class, 'index']);

Route::get('/contacts', [ContactApiController::class, 'index']);