@extends('layouts.base')
@section('page')

<div class="w-full h-screen grid grid-rows-[auto_1fr] grid-cols-[auto_1fr]">

    @include('partials.back.header')

    @include('partials.back.nav')

    <div class="row-start-2 col-start-2  place-self-stretch px-4 pb-4" id="content">
        @yield('content')
    </div>

</div>


@endsection
