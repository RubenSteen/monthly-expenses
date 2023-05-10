<?php

use App\Models\CollectiveExpense;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('can create a collective expense transaction', function () {
    $data = CollectiveExpense::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->collectiveExpense()->create($data);

    expect($user->collectiveExpense)->toHaveCount(1);
});

it('can retrieve a list of collective expense transactions', function () {
    $data = CollectiveExpense::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->collectiveExpense()->create($array);
    }

    expect($user->collectiveExpense)->toHaveCount(5);
});

it('can retrieve the from piggy bank from the collective expense transaction', function () {
    $collectiveExpense = CollectiveExpense::factory()->create();

    expect($collectiveExpense->from)->toBeInstanceOf(App\Models\PiggyBank::class);
});

it('can retrieve the to piggy bank from the collective expense transaction', function () {
    $collectiveExpense = CollectiveExpense::factory()->create();

    expect($collectiveExpense->to)->toBeInstanceOf(App\Models\PiggyBank::class);
});
