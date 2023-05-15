<?php

use App\Models\Income;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('can create a income transaction', function () {
    $data = Income::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->income()->create($data);

    expect($user->income)->toHaveCount(1);
});

it('can retrieve a list of income transactions', function () {
    $data = Income::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->income()->create($array);
    }

    expect($user->income)->toHaveCount(5);
});

it('can retrieve the to piggy bank from the income transaction', function () {
    $income = Income::factory()->create();

    expect($income->to)->toBeInstanceOf(App\Models\PiggyBank::class);
});
