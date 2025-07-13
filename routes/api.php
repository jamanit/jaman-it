<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/chat-ai', [App\Http\Controllers\Api\ChatAIController::class, 'chat']);
