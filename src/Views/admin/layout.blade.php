@extends('main-blog::base')

@section('style-head')
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

@endsection
@section('content')
<div class="flex flex-col flex-1 w-full">
    <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
        <div class="container flex items-center justify-between h-full px-6 mx-auto text-green-600 dark:text-green-300">

            <!-- Mobile hamburger -->
            <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-green"
                @click="toggleSideMenu" aria-label="Menu">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <!-- Search input -->
            <button class="p-1 mr-5 -ml-1 rounded-md hidden md:block focus:outline-none focus:shadow-outline-green"
                @click="toggleSidebarMenu" aria-label="Menu">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
            <div class="flex justify-center flex-1">
                <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                    <img src="{{ asset("assets/images/logo.svg") }}" alt="Logo" class="d-inline-block align-top w-10" alt="" loading="lazy">
                </a>
            </div>
            <ul class="flex items-center flex-shrink-0 space-x-6">
                <li class="relative">
                    <button class="align-middle rounded-full focus:shadow-outline-green focus:outline-none"
                        @click="toggleProfileMenu" @keydown.escape="closeProfileMenu" aria-label="Account"
                        aria-haspopup="true">
                        <img class="object-cover w-8 h-8 rounded-full" alt="" src="" aria-hidden="true" />

                    </button>
                    <template x-if="isProfileMenuOpen">
                        <ul x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0" @click.away="closeProfileMenu"
                            @keydown.escape="closeProfileMenu"
                            class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                            aria-label="submenu">

                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="">
                                    <svg class="w-4 h-4 mr-3" viewBox="0 0 20 20" fill="currentColor"
                                        class="home w-6 h-6">
                                        <path
                                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                        </path>
                                    </svg>
                                    <span>Landing Page</span>
                                </a>
                            </li>
                            <li class="flex">
                                <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                                    href="">
                                    <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Log out</span>
                                </a>
                            </li>
                        </ul>
                    </template>
                </li>
            </ul>
        </div>
    </header>
</div>

@yield('content-admin')
@endsection
