<?php

it('can create a new user', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'johndoe@laravel.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ])->assertSessionHasNoErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'johndoe@laravel.com',
    ]);
});
