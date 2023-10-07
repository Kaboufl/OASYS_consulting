@extends('layouts.base')
@section('page')
<div class="mx-auto max-w-7xl">
                
    @include('partials.front.nav')

    <div class="container px-6 py-32 mx-auto md:text-center md:px-4">
        @yield('content')
    </div>
    <!--
    <div class="container px-6 py-32 mx-auto md:text-center md:px-4">
        <h1 class="text-4xl font-extrabold leading-none leading-10 tracking-tight text-white sm:text-5xl md:text-6xl xl:text-7xl"><span class="block">Simplify the way you</span> <span class="relative inline-block mt-3 text-white">design websites</span></h1>
        <p class="mx-auto mt-6 text-sm text-left text-gray-200 md:text-center md:mt-12 sm:text-base md:max-w-xl md:text-lg xl:text-xl">If you are ready to change the way you design websites, then you'll want to use our block builder to make it fun and easy!</p>
        <div class="relative flex items-center mx-auto mt-12 overflow-hidden text-left border border-gray-700 rounded-md md:max-w-md md:text-center">
            <input type="text" name="email" placeholder="Email Address" class="w-full h-12 px-6 py-2 font-medium text-gray-800 focus:outline-none">
            <span class="relative top-0 right-0 block">
                <button type="button" class="inline-flex items-center w-32 h-12 px-8 text-base font-bold leading-6 text-white transition duration-150 ease-in-out bg-gray-800 border border-transparent hover:bg-gray-700 focus:outline-none active:bg-gray-700" data-primary="gray-600">
                    Sign Up
                </button>
            </span>
        </div>
        <div class="mt-8 text-sm text-gray-300">By signing up, you agree to our terms and services.</div>
    </div>
    -->
</div>
@endSection