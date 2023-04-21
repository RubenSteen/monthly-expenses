<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $this->actingAs($user = User::factory()->create(['password' => Hash::make('Password123!')]));

    $response = $this->put('/user/password', [
        'current_password' => 'Password123!',
        'password' => 'new-Password123!',
        'password_confirmation' => 'new-Password123!',
    ]);

    expect(Hash::check('new-Password123!', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct', function () {
    $this->actingAs($user = User::factory()->create(['password' => Hash::make('Password123!')]));

    $response = $this->put('/user/password', [
        'current_password' => 'wrong-Password123!',
        'password' => 'new-Password123!',
        'password_confirmation' => 'new-Password123!',
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check('Password123!', $user->fresh()->password))->toBeTrue();
});

test('new passwords must match', function () {
    $this->actingAs($user = User::factory()->create(['password' => Hash::make('Password123!')]));

    $response = $this->put('/user/password', [
        'current_password' => 'Password123!',
        'password' => 'new-password',
        'password_confirmation' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();

    expect(Hash::check('Password123!', $user->fresh()->password))->toBeTrue();
});
