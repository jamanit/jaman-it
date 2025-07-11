@extends('layouts.app')

@push('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="py-32 min-h-screen bg-cover bg-center relative" style="background-image: url('{{ asset('assets/images/space-bg.jpg') }}')">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 px-4 sm:px-6 lg:px-12 xl:px-20 text-center">
            <h1 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500 mb-4">Explore Our Free Online Tools</h1>
            <p class="text-lg text-gray-300 mb-8">Discover various smart and handy services, all free and instantly accessible.</p>

            @php
                $serviceBadgeColors = [
                    ['bg-blue-600 hover:bg-blue-700'],
                    ['bg-pink-600 hover:bg-pink-700'],
                    ['bg-yellow-500 hover:bg-yellow-700'],
                    ['bg-green-600 hover:bg-green-700'],
                    ['bg-purple-600 hover:bg-purple-700'],
                    ['bg-red-600 hover:bg-red-700'],
                    ['bg-sky-600 hover:bg-sky-700'],
                    ['bg-rose-600 hover:bg-rose-700'],
                    ['bg-amber-600 hover:bg-amber-700'],
                    ['bg-lime-600 hover:bg-lime-700'],
                    ['bg-indigo-600 hover:bg-indigo-700'],
                    ['bg-fuchsia-600 hover:bg-fuchsia-700'],
                ];
                shuffle($serviceBadgeColors);
            @endphp

            <div class="flex flex-wrap justify-center gap-4">
                @foreach ($services->where('is_popular', true) as $index => $service)
                    @php $color = $serviceBadgeColors[$index % count($serviceBadgeColors)]; @endphp
                    <a href="{{ url($service->slug) }}" class="px-5 py-3 {{ $color[0] }} text-white rounded-full transition shadow-lg animate-bounce">{{ $service->title }}</a>
                @endforeach
            </div>

            <div class="mt-10">
                <a href="javascript:void(0)" @click.prevent="serviceModal = true" class="inline-block px-8 py-4 bg-gradient-to-r from-blue-500 to-pink-500 text-white font-semibold rounded-full hover:scale-105 transform transition shadow-lg">
                    Explore Services
                </a>
            </div>
        </div>
    </section>

    @include('services.service-modal')

    <!-- Posts Section -->
    <section id="post" class="py-24">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20">
            <h2 class="text-2xl font-bold mb-6 text-white">Latest Posts</h2>

            @if ($posts->isEmpty())
                <div class="bg-slate-800 text-white rounded-xl shadow-lg p-8 text-center max-w-xl mx-auto mb-10">
                    <h2 class="text-2xl font-bold mb-2">No Posts Available</h2>
                    <p class="text-gray-400">There are currently no published posts. Please check back later.</p>
                </div>
            @else
                <div id="post-list" class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                    @include('posts.post-card', ['posts' => $posts])
                </div>

                <div class="text-center">
                    <button id="post-load-more" class="cursor-pointer inline-block px-6 py-3 bg-gradient-to-r from-blue-500 to-pink-500 text-white font-semibold rounded-full shadow-lg hover:scale-105 transition duration-300" data-offset="{{ count($posts) }}">
                        See more
                    </button>
                </div>
            @endif
        </div>
    </section>

    @include('posts.post-modal')

    <!-- About Sectionn -->
    <section id="about" class="py-24 bg-slate-900">
        <div class="relative z-10 px-4 sm:px-6 lg:px-12 xl:px-20 text-center">
            @if ($settingItems['logo']->value && Storage::disk('public')->exists($settingItems['logo']->value))
                <img src="{{ Storage::url($settingItems['logo']->value) }}" alt="Logo" class="mx-auto h-20 mb-6 rounded-xl shadow-lg" />
            @else
                <img src="{{ asset('/') }}assets/images/logo.jpg" alt="Logo" class="mx-auto h-20 mb-6 rounded-xl shadow-lg" />
            @endif

            <h1 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-pink-500 mb-4">About {{ $settingItems['site_name']->value ?? '' }}</h1>
            <div class="text-lg text-gray-300 max-w-3xl mx-auto mb-10"> {!! $settingItems['about']->value ?? '' !!}</div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24">
        <div class="px-4 sm:px-6 lg:px-12 xl:px-20 max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-6 text-white">Contact Us</h2>
            <p class="text-center text-gray-400 mb-12">Have questions or feedback? We'd love to hear from you. Get in touch through the form or via our contact details below.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <form class="space-y-6" id="contact-form" method="POST" action="{{ route('home.sendMessage') }}">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your Name" class="w-full px-4 py-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com" class="w-full px-4 py-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500" />
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-1">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Your message..." class="w-full px-4 py-2 rounded-lg bg-slate-800 text-white border border-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="cursor-pointer w-full px-6 py-3 bg-gradient-to-r from-violet-600 to-pink-500 text-white font-semibold rounded-lg hover:scale-105 transition duration-300">Send Message</button>
                    </div>
                </form>

                <div class="bg-slate-800 rounded-xl p-6 text-gray-300 space-y-6">
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Office Address</h3>
                        {{ $settingItems['address']->value ?? '' }}
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Email</h3>
                        <p><a href="mailto:{{ $settingItems['email']->value ?? '' }}" class="text-pink-400 hover:underline">{{ $settingItems['email']->value ?? '' }}</a></p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Phone</h3>
                        <p><a href="tel:{{ $settingItems['phone_number']->value ?? '' }}" class="text-pink-400 hover:underline">{{ $settingItems['phone_number']->value ?? '' }}</a></p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-white">Working Hours</h3>
                        {!! $settingItems['working_hours']->value ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('post-load-more');
            const postList = document.getElementById('post-list');

            loadMoreBtn.addEventListener('click', function() {
                const offset = parseInt(loadMoreBtn.getAttribute('data-offset'));

                loadMoreBtn.innerText = 'Loading...';

                fetch("{{ route('home.loadMorePost') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            offset: offset
                        })
                    })
                    .then(res => res.text())
                    .then(html => {
                        if (html.trim() !== '') {
                            postList.insertAdjacentHTML('beforeend', html);
                            loadMoreBtn.setAttribute('data-offset', offset + 3);
                            loadMoreBtn.innerText = 'See more';
                        } else {
                            loadMoreBtn.innerText = 'No more posts to load';
                            loadMoreBtn.disabled = true;
                            loadMoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        }
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('contact-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            formData.append('_token', '{{ csrf_token() }}');

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (!res.ok) {
                    throw data;
                }

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: true,
                });

                form.reset();
            } catch (err) {
                let message = 'There is an error';

                if (err.errors) {
                    message = Object.values(err.errors).flat().join('\n');
                } else if (err.message) {
                    message = err.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: message,
                });
            }
        });
    </script>
@endpush
