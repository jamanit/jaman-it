<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Service;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

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

        $sessionId = $request->session()->getId();
        $filename = "chat_ai_histories/web_{$sessionId}.json";

        $history = [];
        if (Storage::exists($filename)) {
            $raw = json_decode(Storage::get($filename), true);
            $history = array_filter($raw, fn($h) => in_array($h['role'], ['user', 'assistant']));
        }

        return view('services.chat-ai.index', compact('history'));
    }

    public function chat(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:3',
        ]);

        $text = $request->input('text');
        $reply = 'Sorry, unable to reply.';

        // Use session ID to distinguish web users
        $sessionId = $request->session()->getId();
        $filename = "chat_ai_histories/web_{$sessionId}.json";

        // Load previous chat history if available
        if (Storage::exists($filename)) {
            $history = json_decode(Storage::get($filename), true);
        } else {
            $history = [
                ['role' => 'system', 'content' => "You are a helpful assistant for web users."]
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
        $sessionId = $request->session()->getId();
        $filename = "chat_ai_histories/web_{$sessionId}.json";

        if (Storage::exists($filename)) {
            Storage::delete($filename);
            return response()->json(['message' => 'Chat history cleared successfully.']);
        }

        return response()->json([
            'message' => 'No history found to delete.'
        ], 404);
    }
}
