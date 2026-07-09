<?php

it('redirects to tasks index', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('tasks.index'));
});
