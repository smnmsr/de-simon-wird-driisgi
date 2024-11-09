<?php

it('can render', function () {
    $contents = $this->view('components.footer', [
        //
    ]);

    $contents->assertSee('');
});
