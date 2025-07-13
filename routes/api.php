<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/chat-ai/chat', [App\Http\Controllers\Api\ChatAIController::class, 'chat']);
Route::delete('/chat-ai/clear-history', [App\Http\Controllers\Api\ChatAIController::class, 'clearHistory']);
