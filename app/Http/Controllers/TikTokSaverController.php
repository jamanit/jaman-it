<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Service;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        try {
            $rawUrl   = $request->input('url');
            $cleanUrl = strtok($rawUrl, '?');

            $response = Http::withHeaders([
                'x-rapidapi-key'  => env('RAPIDAPI_KEY'),
                'x-rapidapi-host' => 'tiktok-download-without-watermark.p.rapidapi.com',
            ])->get('https://tiktok-download-without-watermark.p.rapidapi.com/analysis', [
                'url' => $cleanUrl,
                'hd'  => '0', // use '1' for HD if needed
            ]);
            // dd($response->status(), $response->body());

            if (!$response->successful()) {
                return back()->withErrors(['Failed to contact the TikTok downloader service. Please try again later.']);
            }

            $data = $response->json();

            // Extract download link and video title
            $downloadLink = $data['data']['play'] ?? null;
            $videoTitle   = $data['data']['title'] ?? 'TikTok Video';

            if (!$downloadLink) {
                return back()->withErrors(['Sorry, we couldn’t find a downloadable video from that URL.']);
            }

            return redirect()
                ->route('tiktok-saver.index')
                ->with([
                    'download_link' => $downloadLink,
                    'video_title'   => $videoTitle
                ]);
        } catch (\Exception $e) {
            return back()->withErrors(['Something went wrong. Please try again. (' . $e->getMessage() . ')']);
        }
    }
}
