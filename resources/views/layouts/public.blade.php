@extends('layouts.base')

@section('body')
    <div class="min-h-screen w-[1100px] max-w-full mx-auto flex flex-col justify-between text-center">
        <div>
            <div>
                <x-rainbow-text class="text-4xl mt-md mb-xs">De Simon wird Driisgi!</x-rainbow-text>
                <p class="text-sm">Und das isch d Websiite defür. Grund: unbekannt.</p>
            </div>
            <div
                class="relative m-auto p-md pt-lg sm:justify-center sm:items-center w-full">
                @yield('content')
            </div>
        </div>
        <x-footer/>
    </div>
@endsection
