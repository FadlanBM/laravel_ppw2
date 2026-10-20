<?php

test('the application returns a successful response', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
});
