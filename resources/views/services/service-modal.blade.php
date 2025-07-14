<div x-show="serviceModal" x-cloak x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 px-4">
    <div @click.away="serviceModal = false" class="bg-gradient-to-br from-slate-800 to-slate-900 text-white rounded-xl shadow-2xl max-w-5xl w-full max-h-[90vh] flex flex-col transform transition-all duration-300 scale-95 overflow-hidden" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-700 flex-shrink-0 bg-slate-800/80 backdrop-blur-md sticky top-0 z-10">
            <h2 class="text-2xl font-bold">All Services</h2>
            <button @click="serviceModal = false" class="cursor-pointer flex items-center justify-center w-10 h-10 hover:bg-slate-700 text-slate-300 hover:text-white rounded-full transition duration-200" aria-label="Close Modal">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="overflow-y-auto px-6 py-4 mb-4 space-y-4 scrollbar-thin scrollbar-thumb-slate-600 scrollbar-track-slate-950" style="max-height: calc(90vh - 80px);">
            @php shuffle($serviceBadgeColors); @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($services as $index => $service)
                    @php $color = $serviceBadgeColors[$index % count($serviceBadgeColors)]; @endphp
                    <a href="{{ url($service->slug) }}" class="block p-4 rounded-lg shadow-md hover:shadow-lg transition text-white {{ $color[0] }}">
                        <h3 class="text-lg font-semibold mb-2">{{ $service->title }}</h3>
                        <p class="text-sm text-white/80">{{ \Illuminate\Support\Str::limit(strip_tags($service->description), 80) }}</p>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
