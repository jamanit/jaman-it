@extends('layouts.app')

@push('title', 'TikTok Saver')

@section('content')
    <section class="py-24 min-h-screen text-white">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500">TikTok Video Downloader</h2>

            <p class="text-center text-base text-gray-300 max-w-xl mx-auto mb-10">
                Paste the URL of the TikTok video you want to download. It's free, fast, and easy.
            </p>

            @if ($errors->any())
                <div class="bg-red-600 text-white rounded-lg shadow-lg p-4 mb-6">
                    <strong class="block mb-2">Whoops! Something went wrong:</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form x-data="{ isSubmitting: false }" x-on:submit.prevent="isSubmitting = true; $el.submit();" action="{{ route('tiktok-saver.download') }}" method="POST" class="bg-slate-800 p-6 rounded-xl shadow-lg space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-2">URL Video TikTok</label>
                    <input type="url" name="url" placeholder="https://www.tiktok.com/..." class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
                </div>

                <div class="text-center">
                    <button type="submit" x-bind:disabled="isSubmitting" class="cursor-pointer px-6 py-3 bg-gradient-to-r from-blue-500 to-pink-500 text-white font-semibold rounded-lg shadow-lg transition duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting">Get Download Link</span>
                        <span x-show="isSubmitting">Processing...</span>
                    </button>
                </div>
            </form>

            @if (session('download_link'))
                <div class="bg-green-600 text-white rounded-md p-4 mt-6">
                    <p class="text-sm opacity-80 mb-1">Video Title:</p>
                    <h3 class="font-semibold text-lg mb-3">{{ session('video_title') }}</h3>

                    <p class="mb-2">✅ Your video is ready! Click the button below to download:</p>
                    <a href="{{ route('tiktok-saver.stream', [
                        'url' => session('download_link'),
                        'title' => Str::slug(session('video_title'), '-') . '.mp4',
                    ]) }}" class="cursor-pointer inline-block px-4 py-2 bg-white text-green-700 font-medium rounded hover:bg-gray-100 transition">
                        Download Video (HD)
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
