@extends('layouts.base')
@section('page')

<div class="w-full min-h-screen grid grid-rows-[auto_1fr] grid-cols-[auto_1fr]">

    @include('partials.back.header')

    {{-- @if(auth()->user()->admin()->count())
    @include('partials.back.admin.nav')
    @endif

    @if(auth()->user()->chefDe()->count())
    @include('partials.back.chef.nav')
    @endif --}}

    @include('partials.back.nav')



    <div class="row-start-2 col-start-2  place-self-stretch px-4 pb-4" id="content">
        @yield('content')
    </div>

</div>


@endsection
