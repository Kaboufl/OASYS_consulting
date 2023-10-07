<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans min-h-screen w-full px-3 antialiased bg-gradient-to-br from-gray-900 via-black to-gray-800 lg:px-6" 
    x-init="
    window.toast = function(message, options = {}){
        let description = '';
        let type = 'default';
        let position = 'top-center';
        let html = '';
        if(typeof options.description != 'undefined') description = options.description;
        if(typeof options.type != 'undefined') type = options.type;
        if(typeof options.position != 'undefined') position = options.position;
        if(typeof options.html != 'undefined') html = options.html;
        
        window.dispatchEvent(new CustomEvent('toast-show', { detail : { type: type, message: message, description: description, position : position, html: html }}));
    }

    window.customToastHTML = `
        <div class='relative flex items-start justify-center p-4'>
            <img src='https://cdn.devdojo.com/images/august2023/headshot-new.jpeg' class='w-10 h-10 mr-2 rounded-full'>
            <div class='flex flex-col'>
                <p class='text-sm font-medium text-gray-800'>New Friend Request</p>
                <p class='mt-1 text-xs leading-none text-gray-800'>Friend request from John Doe.</p>
                <div class='flex mt-3'>
                    <button type='button' @click='burnToast(toast.id)' class='inline-flex items-center px-2 py-1 text-xs font-semibold text-white bg-indigo-600 rounded shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'>Accept</button>
                    <button type='button' @click='burnToast(toast.id)' class='inline-flex items-center px-2 py-1 ml-3 text-xs font-semibold text-gray-900 bg-white rounded shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50'>Decline</button>
                </div>
            </div>
        </div>
    `
">


@yield('page')

@livewireScripts
</body>

@include('partials.notifications')
@error('admin')
    <div x-init="window.toast('{{ $message }}', {
        type: 'danger',
    })"></div>
@enderror
</html>