<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatAIController extends Controller
{
    public function chat(Request $request)
    {
        $text = $request->input('text');

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
                $reply = $response['choices'][0]['message']['content'] ?? "Sorry, I can't answer at this time.";
            } else {
                Log::error('OpenRouter API error: ' . $response->body());
                $reply = 'Sorry, an error occurred while retrieving the reply from AI.';
            }
        } catch (\Exception $e) {
            Log::error('OpenRouter API failed: ' . $e->getMessage());
            $reply = 'Sorry, there was an error on the AI server. Please try again later.';
        }

        return response()->json([
            'reply' => $reply
        ]);
    }
}
