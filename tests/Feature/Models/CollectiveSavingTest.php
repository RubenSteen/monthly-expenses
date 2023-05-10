<?php

use App\Models\CollectiveSaving;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('can create a collective saving transaction', function () {
    $data = CollectiveSaving::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->collectiveSaving()->create($data);

    expect($user->collectiveSaving)->toHaveCount(1);
});

it('can retrieve a list of collective saving transactions', function () {
    $data = CollectiveSaving::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->collectiveSaving()->create($array);
    }

    expect($user->collectiveSaving)->toHaveCount(5);
});

it('can retrieve the from piggy bank from the collective saving transaction', function () {
    $collectiveSaving = CollectiveSaving::factory()->create();

    expect($collectiveSaving->from)->toBeInstanceOf(App\Models\PiggyBank::class);
});

it('can retrieve the to piggy bank from the collective saving transaction', function () {
    $collectiveSaving = CollectiveSaving::factory()->create();

    expect($collectiveSaving->to)->toBeInstanceOf(App\Models\PiggyBank::class);
});
