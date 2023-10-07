@extends('layouts.base')
@section('page')
<div class="mx-auto max-w-7xl">
                
    @include('partials.front.nav')

    <div class="container px-6 py-32 mx-auto md:text-center md:px-4">
        @yield('content')
    </div>
   
</div>
@endSection
