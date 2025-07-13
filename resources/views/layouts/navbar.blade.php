<div x-data="{ sidebarOpen: false, active: '', activeDropdown: '', activeDropdownLink: '' }" x-cloak>
    <!-- Navbar wrapper -->
    <div x-data="navbarScroll()" x-init="init()" class="px-4 sm:px-6 lg:px-12 xl:px-20 mt-2 fixed top-0 left-0 right-0 z-20">
        <nav id="navbar" :class="scrolled ? 'bg-gradient-to-r from-violet-600 to-pink-600 shadow-md' : 'bg-slate-800/50'" class="transition duration-500 ease-in-out rounded-xl backdrop-blur-md">
            <div class="flex justify-between items-center px-6 py-2">
                <a href="/">
                    @if ($settingItems['logo']->value && Storage::disk('public')->exists($settingItems['logo']->value))
                        <img src="{{ Storage::url($settingItems['logo']->value) }}" alt="Logo" class="h-10 rounded" />
                    @else
                        <img src="{{ asset('/') }}assets/images/logo.jpg" alt="Logo" class="h-10 rounded" />
                    @endif
                </a>

                <!-- Hamburger button -->
                <button @click="sidebarOpen = true" class="cursor-pointer md:hidden p-2 rounded-full hover:bg-pink-500 focus:outline-none transition transform hover:scale-110 duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Menu desktop -->
                <ul x-data="{ active: 'Home', activeSub: '' }" class="hidden md:flex items-center space-x-6 font-medium">
                    <li>
                        <a href="/" @click="active = 'Home'; activeSub = ''" :class="active === 'Home' ? 'bg-pink-500' : ''" class="p-2 text-white hover:bg-pink-500 rounded-lg transition duration-300">Home</a>
                    </li>
                    <li class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <button @click.prevent="active = 'Services'" :class="active === 'Services' ? 'bg-pink-500' : ''" class="p-2 text-white hover:bg-pink-500 rounded-lg transition duration-300 inline-flex items-center gap-1">
                            Services
                            <svg class="w-4 h-4 mt-0.5 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <ul x-show="open" x-transition class="absolute z-20 left-0 mt-2 w-40 bg-slate-800 text-white rounded-lg shadow-lg transition duration-300 overflow-hidden">
                            @foreach ($services->where('is_popular', true) as $service)
                                <li>
                                    <a href="{{ url($service->slug) }}" @click="active = 'Services'; activeSub = '{{ $service->title }}'" :class="activeSub === '{{ $service->title }}' ? 'bg-pink-500' : ''" class="block px-4 py-2 hover:bg-pink-500 transition duration-200">
                                        {{ $service->title }}
                                    </a>
                                </li>
                            @endforeach

                            <li>
                                <a href="javascript:void(0)" @click="active = 'Services'; activeSub = 'View All Services'; serviceModal = true" :class="activeSub === 'View All Services' ? 'bg-pink-500' : ''" class="block px-4 py-2 hover:bg-pink-500 transition duration-200">
                                    View All Services
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="/#post" @click="active = 'Post'; activeSub = ''" :class="active === 'Post' ? 'bg-pink-500' : ''" class="p-2 text-white hover:bg-pink-500 rounded-lg transition duration-300">Post</a>
                    </li>
                    <li>
                        <a href="/#about" @click="active = 'About'; activeSub = ''" :class="active === 'About' ? 'bg-pink-500' : ''" class="p-2 text-white hover:bg-pink-500 rounded-lg transition duration-300">About</a>
                    </li>
                    <li>
                        <a href="/#contact" @click="active = 'Contact'; activeSub = ''" :class="active === 'Contact' ? 'bg-pink-500' : ''" class="p-2 text-white hover:bg-pink-500 rounded-lg transition duration-300">Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Sidebar Mobile -->
    <div x-show="sidebarOpen" x-transition:enter="transition transform duration-300 ease-in-out" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition transform duration-300 ease-in-out" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        class="fixed top-0 left-0 h-full w-72 bg-violet-600 text-white shadow-2xl z-30 md:hidden rounded-tr-2xl rounded-br-2xl overflow-y-auto">
        <div class="px-6 py-2 flex justify-between items-center border-b border-violet-500">
            <h2 class="text-xl font-semibold">Menu</h2>
            <button @click="sidebarOpen = false" class="cursor-pointer text-white p-2 rounded-full hover:bg-violet-500 focus:outline-none transition transform hover:scale-110 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul x-data="{ active: '', activeDropdown: '' }" class="p-6 space-y-3 font-medium">
            <li>
                <a href="/" @click="active = 'Home'; activeDropdown = ''; activeDropdownLink = ''; sidebarOpen = false" :class="active === 'Home' ? 'bg-violet-500' : ''" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-violet-500 transition duration-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M21.5315 11.5857L20.75 10.9605V21.25H22C22.4142 21.25 22.75 21.5858 22.75 22C22.75 22.4143 22.4142 22.75 22 22.75H2.00003C1.58581 22.75 1.25003 22.4143 1.25003 22C1.25003 21.5858 1.58581 21.25 2.00003 21.25H3.25003V10.9605L2.46855 11.5857C2.1451 11.8445 1.67313 11.792 1.41438 11.4686C1.15562 11.1451 1.20806 10.6731 1.53151 10.4144L9.65742 3.91366C11.027 2.818 12.9731 2.818 14.3426 3.91366L22.4685 10.4144C22.792 10.6731 22.8444 11.1451 22.5857 11.4686C22.3269 11.792 21.855 11.8445 21.5315 11.5857ZM12 6.75004C10.4812 6.75004 9.25003 7.98126 9.25003 9.50004C9.25003 11.0188 10.4812 12.25 12 12.25C13.5188 12.25 14.75 11.0188 14.75 9.50004C14.75 7.98126 13.5188 6.75004 12 6.75004ZM13.7459 13.3116C13.2871 13.25 12.7143 13.25 12.0494 13.25H11.9507C11.2858 13.25 10.7129 13.25 10.2542 13.3116C9.76255 13.3777 9.29128 13.5268 8.90904 13.9091C8.52679 14.2913 8.37773 14.7626 8.31163 15.2542C8.24996 15.7129 8.24999 16.2858 8.25003 16.9507L8.25003 21.25H9.75003H14.25H15.75L15.75 16.9507L15.75 16.8271C15.7498 16.2146 15.7462 15.6843 15.6884 15.2542C15.6223 14.7626 15.4733 14.2913 15.091 13.9091C14.7088 13.5268 14.2375 13.3777 13.7459 13.3116Z"
                                fill="#ffffff"></path>
                            <g opacity="0.5">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 9.5C10.75 8.80964 11.3096 8.25 12 8.25C12.6904 8.25 13.25 8.80964 13.25 9.5C13.25 10.1904 12.6904 10.75 12 10.75C11.3096 10.75 10.75 10.1904 10.75 9.5Z" fill="#ffffff"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 9.5C10.75 8.80964 11.3096 8.25 12 8.25C12.6904 8.25 13.25 8.80964 13.25 9.5C13.25 10.1904 12.6904 10.75 12 10.75C11.3096 10.75 10.75 10.1904 10.75 9.5Z" fill="#ffffff"></path>
                            </g>
                            <path opacity="0.5"
                                d="M12.0494 13.25C12.7142 13.25 13.2871 13.2499 13.7458 13.3116C14.2375 13.3777 14.7087 13.5268 15.091 13.909C15.4732 14.2913 15.6223 14.7625 15.6884 15.2542C15.7462 15.6842 15.7498 16.2146 15.75 16.827L15.75 21.25H8.25L8.25 16.9506C8.24997 16.2858 8.24993 15.7129 8.31161 15.2542C8.37771 14.7625 8.52677 14.2913 8.90901 13.909C9.29126 13.5268 9.76252 13.3777 10.2542 13.3116C10.7129 13.2499 11.2858 13.25 11.9506 13.25H12.0494Z"
                                fill="#ffffff"></path>
                            <path opacity="0.5" d="M16 3H18.5C18.7761 3 19 3.22386 19 3.5L19 7.63955L15.5 4.83955V3.5C15.5 3.22386 15.7239 3 16 3Z" fill="#ffffff"></path>
                        </g>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <button @click.prevent="active = 'Services'; activeDropdown = activeDropdown === 'Services' ? '' : 'Services'" :class="active === 'Services' ? 'bg-violet-500' : ''" class="flex justify-between items-center w-full px-4 py-2 rounded-lg hover:bg-violet-500 transition duration-300">
                    <div class="flex items-center gap-2">
                        <svg class="h-6 w-6" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" fill="#ffffff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Layer_2" data-name="Layer 2">
                                    <g id="invisible_box" data-name="invisible box">
                                        <rect width="48" height="48" fill="none"></rect>
                                        <rect width="48" height="48" fill="none"></rect>
                                        <rect width="48" height="48" fill="none"></rect>
                                    </g>
                                    <g id="icons_Q2" data-name="icons Q2">
                                        <path d="M28.7,18.8l-1.8,2.9,1.4,1.4,2.9-1.8,1,.4L33,25h2l.8-3.3,1-.4,2.9,1.8,1.4-1.4-1.8-2.9a4.2,4.2,0,0,0,.4-1L43,17V15l-3.3-.8a4.2,4.2,0,0,0-.4-1l1.8-2.9L39.7,8.9l-2.9,1.8-1-.4L35,7H33l-.8,3.3-1,.4L28.3,8.9l-1.4,1.4,1.8,2.9a4.2,4.2,0,0,0-.4,1L25,15v2l3.3.8A4.2,4.2,0,0,0,28.7,18.8ZM34,14a2,2,0,1,1-2,2A2,2,0,0,1,34,14Z"></path>
                                        <path d="M42.2,28.7a5.2,5.2,0,0,0-4-1.1l-9.9,1.8a4.5,4.5,0,0,0-1.4-3.3L19.8,19H5a2,2,0,0,0-2,2v9a2,2,0,0,0,2,2H8.3l11.2,9.1,20.4-3.7a5,5,0,0,0,2.3-8.7Zm-3,4.8L20.5,36.9,10,28.2V23h8.2l5.9,5.9a.8.8,0,0,1-1.2,1.2l-3.5-3.5a2,2,0,0,0-2.8,2.8l3.5,3.5a4.5,4.5,0,0,0,3.4,1.4,5.7,5.7,0,0,0,1.8-.3h0l13.6-2.4a1.1,1.1,0,0,1,.8.2.9.9,0,0,1,.3.7A1,1,0,0,1,39.2,33.5Z">
                                        </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        Services
                    </div>
                    <svg class="w-4 h-4 transform transition-transform duration-300 group-[.open]:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul x-show="activeDropdown === 'Services'" x-transition class="mt-1 space-y-1 bg-white text-black rounded-lg shadow-lg p-4">
                    @foreach ($services->where('is_popular', true) as $service)
                        <li>
                            <a href="{{ url($service->slug) }}" @click="activeDropdownLink = '{{ $service->title }}'; sidebarOpen = false" class="group relative inline-block py-1 text-sm font-medium text-black transition duration-300 hover:text-violet-700">
                                {{ $service->title }}
                                <span class="absolute left-0 bottom-0 h-[2px] bg-violet-500 transition-all duration-300 ease-in-out" :class="activeDropdownLink === '{{ $service->title }}' ? 'w-full' : 'w-0 group-hover:w-full'"></span>
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a href="javascript:void(0)" @click="activeDropdownLink = 'View All Services'; serviceModal = true; sidebarOpen = false" class="group relative inline-block py-1 text-sm font-medium text-black transition duration-300 hover:text-violet-700">
                            View All Services
                            <span class="absolute left-0 bottom-0 h-[2px] bg-violet-500 transition-all duration-300 ease-in-out" :class="activeDropdownLink === 'View All Services' ? 'w-full' : 'w-0 group-hover:w-full'"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/#post" @click="active = 'Post'; activeDropdown = ''; activeDropdownLink = ''; sidebarOpen = false" :class="active === 'Post' ? 'bg-violet-500' : ''" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-violet-500 transition duration-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2 5C2 3.34315 3.34315 2 5 2H19C20.6569 2 22 3.34315 22 5V19C22 20.6569 20.6569 22 19 22H5C3.34315 22 2 20.6569 2 19V5ZM5 4C4.44772 4 4 4.44772 4 5V10H20V5C20 4.44772 19.5523 4 19 4H5ZM4 12V19C4 19.5523 4.44772 20 5 20H19C19.5523 20 20 19.5523 20 19V12H4ZM14 13C14.2652 13 14.5196 13.1054 14.7071 13.2929L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L14 15.4142L11.7071 17.7071L10.7071 18.7071C10.3166 19.0976 9.68342 19.0976 9.29289 18.7071C8.90237 18.3166 8.90237 17.6834 9.29289 17.2929L9.58579 17L9 16.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L8.29289 14.2929C8.48043 14.1054 8.73478 14 9 14C9.26522 14 9.51957 14.1054 9.70711 14.2929L11 15.5858L13.2929 13.2929C13.4804 13.1054 13.7348 13 14 13ZM11 7C11 6.44772 11.4477 6 12 6H17C17.5523 6 18 6.44772 18 7C18 7.55228 17.5523 8 17 8H12C11.4477 8 11 7.55228 11 7ZM7 8.75C7.9665 8.75 8.75 7.9665 8.75 7C8.75 6.0335 7.9665 5.25 7 5.25C6.0335 5.25 5.25 6.0335 5.25 7C5.25 7.9665 6.0335 8.75 7 8.75Z"
                                fill="#ffffff"></path>
                        </g>
                    </svg>
                    Post
                </a>
            </li>
            <li>
                <a href="/#about" @click="active = 'About'; activeDropdown = ''; activeDropdownLink = ''; sidebarOpen = false" :class="active === 'About' ? 'bg-violet-500' : ''" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-violet-500 transition duration-300">
                    <svg class="h-6 w-6" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="about-white" fill="#ffffff" transform="translate(42.666667, 42.666667)">
                                    <path
                                        d="M213.333333,3.55271368e-14 C95.51296,3.55271368e-14 3.55271368e-14,95.51168 3.55271368e-14,213.333333 C3.55271368e-14,331.153707 95.51296,426.666667 213.333333,426.666667 C331.154987,426.666667 426.666667,331.153707 426.666667,213.333333 C426.666667,95.51168 331.154987,3.55271368e-14 213.333333,3.55271368e-14 Z M213.333333,384 C119.227947,384 42.6666667,307.43872 42.6666667,213.333333 C42.6666667,119.227947 119.227947,42.6666667 213.333333,42.6666667 C307.44,42.6666667 384,119.227947 384,213.333333 C384,307.43872 307.44,384 213.333333,384 Z M240.04672,128 C240.04672,143.46752 228.785067,154.666667 213.55008,154.666667 C197.698773,154.666667 186.713387,143.46752 186.713387,127.704107 C186.713387,112.5536 197.99616,101.333333 213.55008,101.333333 C228.785067,101.333333 240.04672,112.5536 240.04672,128 Z M192.04672,192 L234.713387,192 L234.713387,320 L192.04672,320 L192.04672,192 Z"
                                        id="Shape"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                    About
                </a>
            </li>
            <li>
                <a href="/#contact" @click="active = 'Contact'; activeDropdown = ''; activeDropdownLink = ''; sidebarOpen = false" :class="active === 'Contact' ? 'bg-violet-500' : ''" class="flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-violet-500 transition duration-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M14.05 6C15.0268 6.19057 15.9244 6.66826 16.6281 7.37194C17.3318 8.07561 17.8095 8.97326 18 9.95M14.05 2C16.0793 2.22544 17.9716 3.13417 19.4163 4.57701C20.8609 6.01984 21.7721 7.91101 22 9.94M18.5 21C9.93959 21 3 14.0604 3 5.5C3 5.11378 3.01413 4.73086 3.04189 4.35173C3.07375 3.91662 3.08968 3.69907 3.2037 3.50103C3.29814 3.33701 3.4655 3.18146 3.63598 3.09925C3.84181 3 4.08188 3 4.56201 3H7.37932C7.78308 3 7.98496 3 8.15802 3.06645C8.31089 3.12515 8.44701 3.22049 8.55442 3.3441C8.67601 3.48403 8.745 3.67376 8.88299 4.05321L10.0491 7.26005C10.2096 7.70153 10.2899 7.92227 10.2763 8.1317C10.2643 8.31637 10.2012 8.49408 10.0942 8.64506C9.97286 8.81628 9.77145 8.93713 9.36863 9.17882L8 10C9.2019 12.6489 11.3501 14.7999 14 16L14.8212 14.6314C15.0629 14.2285 15.1837 14.0271 15.3549 13.9058C15.5059 13.7988 15.6836 13.7357 15.8683 13.7237C16.0777 13.7101 16.2985 13.7904 16.74 13.9509L19.9468 15.117C20.3262 15.255 20.516 15.324 20.6559 15.4456C20.7795 15.553 20.8749 15.6891 20.9335 15.842C21 16.015 21 16.2169 21 16.6207V19.438C21 19.9181 21 20.1582 20.9007 20.364C20.8185 20.5345 20.663 20.7019 20.499 20.7963C20.3009 20.9103 20.0834 20.9262 19.6483 20.9581C19.2691 20.9859 18.8862 21 18.5 21Z"
                                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </g>
                    </svg>
                    Contact
                </a>
            </li>
        </ul>
    </div>

    <!-- Overlay -->
    <div x-show="sidebarOpen" x-transition @click="sidebarOpen = false" class="fixed inset-0 bg-black opacity-30 z-20 md:hidden" x-cloak></div>
</div>
