<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Service;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class TikTokSaverController extends Controller
{

    public function index(Request $request)
    {
        $service = Service::where('slug', 'tiktok-saver')->first();

        if ($service) {
            $cookieName = 'viewed_service_' . $service->id;
            if (!$request->cookie($cookieName)) {
                $service->increment('view_total');
                Cookie::queue($cookieName, true, 10);
            }
        }

        return view('services.tiktok-saver.index');
    }

    public function download(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ], [
            'url.required' => 'Please enter a TikTok video URL.',
            'url.url' => 'The URL you entered is not valid.'
        ]);

        $rawUrl   = $request->input('url');
        $cleanUrl = strtok($rawUrl, '?');
        $apiKeys  = explode(',', env('RAPIDAPI_KEY'));
        $host     = 'tiktok-download-without-watermark.p.rapidapi.com';
        $endpoint = "https://{$host}/analysis";

        $response = null;
        $data = null;
        $success = false;
        $lastError = '';

        foreach ($apiKeys as $key) {
            try {
                $response = Http::withHeaders([
                    'x-rapidapi-key'  => trim($key),
                    'x-rapidapi-host' => $host,
                ])->get($endpoint, [
                    'url' => $cleanUrl,
                    'hd'  => '1',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $success = true;
                    break;
                } else {
                    $lastError = $response->body();
                }
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                continue;
            }
        }

        if (!$success) {
            Log::error('TikTok downloader failed', [
                'error' => $lastError,
                'url'   => $cleanUrl,
            ]);

            return back()->withErrors([
                'Oops! The TikTok download service is currently unavailable. Please try again later.'
            ]);
        }

        $downloadLink = $data['data']['play'] ?? null;
        $videoTitle   = $data['data']['title'] ?? 'TikTok Video';

        if (!$downloadLink) {
            return back()->withErrors([
                'Sorry, we couldn’t extract a downloadable video from that TikTok link.'
            ]);
        }

        return redirect()
            ->route('tiktok-saver.index')
            ->with([
                'download_link' => $downloadLink,
                'video_title'   => $videoTitle
            ]);
    }

    public function stream(Request $request)
    {
        $videoUrl = $request->query('url');
        $title = $request->query('title', 'tiktok-video.mp4');

        if (!$videoUrl) {
            abort(404);
        }

        return response()->streamDownload(function () use ($videoUrl) {
            echo file_get_contents($videoUrl);
        }, $title, [
            'Content-Type' => 'video/mp4'
        ]);
    }
}
