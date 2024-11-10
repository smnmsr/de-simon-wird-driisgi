@extends('layouts.public')

@php

    // get user-name if logged in
    $user = auth()->user();
    $userName = $user ? $user->name : null;

    // make a greeting based on the time of day
    $hour = date('H');
    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Guete Morge ' . $userName;
    } elseif ($hour >= 12 && $hour < 18) {
        $greeting = 'Guete Tag ' . $userName;
    } elseif ($hour >= 18 && $hour <= 23) {
        $greeting = 'Guete Abig ' . $userName;
    } else {
        $greeting = 'Salüüü ' . $userName;
    }

@endphp

@section('content')
    <x-wordart-paper-bag class="text-3xl pb-md">
        {{ $greeting }}
    </x-wordart-paper-bag>
    @if(auth()->check())
        <p>
            Du bisch jetzt igloggt.
        </p>
    @else
        <p>
            Wenn du uf dere Siite glandet bisch, denn bisch wohl du dere Fete iglade.
        </p>
        <p>
            Zum alli Infos gseh, tuen dich bitte ilogge.
        </p>

        <livewire:login-form/>
    @endif
@endsection
