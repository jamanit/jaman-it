@php
    $postBadgeColors = [
        ['bg-blue-600', 'group-hover:text-blue-400'],
        ['bg-pink-600', 'group-hover:text-pink-400'],
        ['bg-yellow-500', 'group-hover:text-yellow-400'],
        ['bg-green-600', 'group-hover:text-green-400'],
        ['bg-purple-600', 'group-hover:text-purple-400'],
        ['bg-red-600', 'group-hover:text-red-400'],
        ['bg-sky-600', 'group-hover:text-sky-400'],
        ['bg-rose-600', 'group-hover:text-rose-400'],
        ['bg-amber-600', 'group-hover:text-amber-400'],
        ['bg-lime-600', 'group-hover:text-lime-400'],
        ['bg-indigo-600', 'group-hover:text-indigo-400'],
        ['bg-fuchsia-600', 'group-hover:text-fuchsia-400'],
    ];
    shuffle($postBadgeColors);
@endphp

@foreach ($posts as $index => $post)
    @php $color = $postBadgeColors[$index % count($postBadgeColors)]; @endphp
    <a href="javascript:void(0)" @click='postModal = true; post = {
       title: @json($post->title),
       content: @json($post->content),
       image: @json($post->image && Storage::disk('public')->exists($post->image) ? Storage::url($post->image) : 'https://dummyimage.com/300'),
       date: @json(\Carbon\Carbon::parse($post->created_at)->translatedFormat('l, d F Y')),
       category: @json($post->category ? $post->category->name : null),
       categoryColor: @json($color[0])
   }'
        class="group block bg-slate-800 rounded-lg overflow-hidden shadow-lg transition hover:scale-[1.02] duration-300 cursor-pointer">

        @if ($post->image && Storage::disk('public')->exists($post->image))
            <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover" />
        @else
            <img src="https://dummyimage.com/300" alt="Post" class="w-full h-56 object-cover" />
        @endif
        <div class="p-6">
            @if ($post->category)
                <span class="inline-block {{ $color[0] }} text-white text-xs px-2 py-1 rounded-full mb-3">{{ $post->category->name ?? '' }}</span>
            @endif
            <h3 class="text-xl font-semibold text-white mb-2 transition {{ $color[1] }} line-clamp-1">{{ $post->title }}</h3>
            <p class="text-sm text-gray-500 mb-2">
                {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('l, d F Y') }}
            </p>
            <div class="text-gray-400 text-sm line-clamp-2">{!! $post->content !!}</div>
        </div>
    </a>
@endforeach
