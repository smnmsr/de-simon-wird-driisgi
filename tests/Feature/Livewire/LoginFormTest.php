<?php

use Livewire\Volt\Volt;

it('can render', function () {
    $component = Volt::test('login-form');

    $component->assertSee('');
});
