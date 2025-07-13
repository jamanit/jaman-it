@extends('layouts.app')

@push('title', 'Image to PDF')

@section('content')
    <section class="py-24 min-h-screen">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500">Convert Image to PDF</h2>

            <p class="text-center text-base text-gray-300 max-w-xl mx-auto mb-10">
                Easily turn your photos into a beautiful PDF. Just upload, choose your layout, and download. Fast, simple, and totally free!
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

            <form x-data="{ isSubmitting: false }" x-on:submit="isSubmitting = true; setTimeout(() => isSubmitting = false, 3000)" action="{{ route('image-to-pdf.convert') }}" method="POST" enctype="multipart/form-data" class="bg-slate-800 p-6 rounded-xl shadow-lg space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-2">Select images</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 cursor-pointer">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Page orientation</label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="orientation" value="portrait" checked class="text-pink-500 focus:ring-pink-500 cursor-pointer">
                            <span>Portrait</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="orientation" value="landscape" class="text-pink-500 focus:ring-pink-500 cursor-pointer">
                            <span>Landscape</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Use margin?</label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="use_margin" value="yes" checked class="text-pink-500 focus:ring-pink-500 cursor-pointer">
                            <span>Yes</span>
                        </label>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="use_margin" value="no" class="text-pink-500 focus:ring-pink-500 cursor-pointer">
                            <span>No</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Vertical Position</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach (['top', 'center', 'bottom'] as $vPos)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="vertical_position" value="{{ $vPos }}" {{ $vPos === 'center' ? 'checked' : '' }} class="text-pink-500 focus:ring-pink-500 cursor-pointer">
                                    <span class="capitalize">{{ $vPos }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Horizontal Position</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach (['left', 'center', 'right'] as $hPos)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="radio" name="horizontal_position" value="{{ $hPos }}" {{ $hPos === 'center' ? 'checked' : '' }} class="text-pink-500 focus:ring-pink-500 cursor-pointer">
                                    <span class="capitalize">{{ $hPos }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" x-bind:disabled="isSubmitting" class="cursor-pointer px-6 py-3 bg-gradient-to-r from-blue-500 to-pink-500 text-white font-semibold rounded-lg shadow-lg hover:scale-105 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting">Convert to PDF</span>
                        <span x-show="isSubmitting">Processing...</span>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush
