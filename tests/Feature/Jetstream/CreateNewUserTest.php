<?php

it('can create a new user', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'johndoe@laravel.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'johndoe@laravel.com',
    ]);
});
