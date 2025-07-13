<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatAIController extends Controller
{
    public function chat(Request $request)
    {
        $from = $request->input('from');
        $text = $request->input('text');

        $filename = "chat_ai_histories/{$from}.json";

        // Load previous chat history if available
        if (Storage::exists($filename)) {
            $history = json_decode(Storage::get($filename), true);
        } else {
            $history = [
                ['role' => 'system', 'content' => "You are a helpful assistant for WhatsApp users."]
            ];
        }

        // Add new user message to history
        $history[] = ['role' => 'user', 'content' => $text];

        // Keep only the last 20 messages plus the initial system prompt
        $history = array_merge([$history[0]], array_slice($history, -20));

        // Get API keys from .env
        $apiKeys = array_map('trim', explode(',', env('OPENROUTER_API_KEY_ARRAY')));

        foreach ($apiKeys as $apiKey) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'HTTP-Referer' => 'http://127.0.0.1:8000',
                    'X-Title' => 'Chat AI',
                    'Content-Type' => 'application/json',
                ])
                    ->timeout(30)
                    ->post('https://openrouter.ai/api/v1/chat/completions', [
                        'model' => 'deepseek/deepseek-chat-v3-0324:free',
                        'messages' => $history,
                    ]);

                if ($response->successful()) {
                    $reply = $response['choices'][0]['message']['content'] ?? 'Sorry, no response was returned.';
                    $history[] = ['role' => 'assistant', 'content' => $reply];

                    // Save updated chat history
                    Storage::put($filename, json_encode($history));

                    // if successful, stop key attempts
                    break;
                } else {
                    Log::error('OpenRouter API error: ' . $response->body());
                    $reply = 'Failed to retrieve a response from the AI.';
                }
            } catch (\Exception $e) {
                Log::error('OpenRouter API exception: ' . $e->getMessage());
                $reply = 'A system error occurred while processing your request.';
            }
        }

        return response()->json([
            'reply' => $reply
        ]);
    }

    public function clearHistory(Request $request)
    {
        $from = $request->input('from');

        if (!$from) {
            return response()->json([
                'message' => 'Missing "from" parameter.'
            ], 400);
        }

        $filename = "chat_ai_histories/{$from}.json";

        if (Storage::exists($filename)) {
            Storage::delete($filename);
            return response()->json([
                'message' => 'Chat history cleared successfully.'
            ]);
        }

        return response()->json([
            'message' => 'No history found to delete.'
        ], 404);
    }
}
