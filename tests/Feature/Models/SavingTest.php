<?php

use App\Models\Saving;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('can create a saving transaction', function () {
    $data = Saving::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->savings()->create($data);

    expect($user->savings)->toHaveCount(1);
});

it('can retrieve a list of saving transactions', function () {
    $data = Saving::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->savings()->create($array);
    }

    expect($user->savings)->toHaveCount(5);
});

it('can retrieve the from piggy bank from the saving transaction', function () {
    $saving = Saving::factory()->create();

    expect($saving->from)->toBeInstanceOf(App\Models\PiggyBank::class);
});

it('can retrieve the to piggy bank from the saving transaction', function () {
    $saving = Saving::factory()->create();

    expect($saving->to)->toBeInstanceOf(App\Models\PiggyBank::class);
});
