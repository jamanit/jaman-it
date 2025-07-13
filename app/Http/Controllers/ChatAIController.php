<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use Illuminate\Support\Facades\Cookie;

class ChatAIController extends Controller
{
    public function index(Request $request)
    {
        $service = Service::where('slug', 'chat-ai')->first();

        if ($service) {
            $cookieName = 'viewed_service_' . $service->id;
            if (!$request->cookie($cookieName)) {
                $service->increment('view_total');
                Cookie::queue($cookieName, true, 10);
            }
        }

        return view('services.chat-ai.index');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:3',
        ]);

        $text = $request->input('text');
        $reply = 'Sorry, unable to reply.';

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'HTTP-Referer' => 'http://127.0.0.1:8000',
                'X-Title' => 'Chat AI',
                'Content-Type' => 'application/json',
            ])
                ->timeout(30)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model' => 'deepseek/deepseek-chat-v3-0324:free',
                    'messages' => [
                        ['role' => 'system', 'content' => "You are WhatsApp's friendly assistant."],
                        ['role' => 'user', 'content' => $text],
                    ],
                ]);

            if ($response->successful()) {
                $reply = $response['choices'][0]['message']['content'] ?? $reply;
            } else {
                Log::error('OpenRouter API error: ' . $response->body());
                $reply = 'Sorry, failed to get reply.';
            }
        } catch (\Exception $e) {
            Log::error('OpenRouter API failed: ' . $e->getMessage());
            $reply = 'Sorry, internal error.';
        }

        return response()->json([
            'reply' => $reply
        ]);
    }
}
