<?php

it('can render', function () {
    $contents = $this->view('components.rainbow-text', [
        //
    ]);

    $contents->assertSee('');
});
