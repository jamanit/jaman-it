<button x-show="showScroll" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-transition
    class="
    fixed bottom-6 right-6
    w-12 h-12
    bg-gradient-to-tr from-violet-500 via-pink-500 to-pink-500
    text-white
    rounded-full
    shadow-2xl
    flex items-center justify-center
    transform
    transition
    duration-300
    hover:scale-110 hover:shadow-violet-400/70
    active:scale-95
    focus:outline-none
    focus:ring-4 focus:ring-violet-400/50
    animate-pulse-slow
    cursor-pointer
    z-50
  "
    aria-label="Scroll to top" title="Scroll to top">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
    </svg>
</button>

<style>
    @keyframes pulse-slow {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: 0.8;
            transform: scale(1.05);
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 2.5s ease-in-out infinite;
    }
</style>
