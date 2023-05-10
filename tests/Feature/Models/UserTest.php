<?php

use App\Models\PiggyBank;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\{actingAs};

it('every new user automaticly gets 1 piggy bank named eigen rekening', function () {
    $user = User::factory()->create();

    expect($user->piggyBanks)->toHaveCount(1);
});

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

it('can create a piggy bank', function () {
    $data = PiggyBank::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->piggyBanks()->create($data);

    expect($user->piggyBanks)->toHaveCount(2);
});

it('can retrieve a list of piggy banks', function () {
    $data = PiggyBank::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->piggyBanks()->create($array);
    }

    expect($user->piggyBanks)->toHaveCount(6);
});
