@extends('layouts.app')

@push('title', 'Word to PDF Converter')

@section('content')
    <section class="py-24 min-h-screen text-white">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20 max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500">Word to PDF Converter</h2>

            <p class="text-center text-base text-gray-300 max-w-xl mx-auto mb-10">
                Upload your .doc or .docx file and get an instant PDF version. Simple, fast, and secure.
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

            <form x-data="{ isSubmitting: false }" x-on:submit="isSubmitting = true; setTimeout(() => isSubmitting = false, 3000)" action="{{ route('word-to-pdf.convert') }}" method="POST" enctype="multipart/form-data" class="bg-slate-800 p-6 rounded-xl shadow-lg space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium mb-2">Upload Word File (.doc / .docx)</label>
                    <input type="file" name="word_files[]" multiple accept=".doc,.docx" class="w-full bg-slate-700 border border-slate-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500 cursor-pointer">
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
