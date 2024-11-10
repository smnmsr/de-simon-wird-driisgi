@extends('layouts.base')

@section('body')
    <div class="min-h-screen w-[1100px] max-w-full mx-auto flex flex-col justify-between text-center">
        <div>
            <a href="/" class="block">
                <x-wordart-rainbow class="text-4xl mt-md mb-xs">De Simon wird Driisgi!</x-wordart-rainbow>
                <p class="text-xs">Und das isch d Websiite defür. Grund: es isch halt de simon.</p>
            </a>
            <div
                class="relative p-md pt-lg w-full flex flex-col space-y-xs">
                @yield('content')
            </div>
        </div>
        <x-footer/>
    </div>
@endsection
