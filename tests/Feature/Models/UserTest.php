<?php

use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\{actingAs};

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('updates the last_activity record when a user makes a request', function () {
    $user = User::factory()->create(); // Observer 'creating' bypass
    $user->last_activity = now()->subDay();
    $user->save();

    actingAs($user)
        ->get('/')
        ->assertStatus(200);

    expect(Carbon::parse($user->fresh()->last_activity)->diffInMinutes(now()))
        ->toBe(0);
});
