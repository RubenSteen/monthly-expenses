<?php

use App\Models\Expense;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('can create a expense transaction', function () {
    $data = Expense::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->expense()->create($data);

    expect($user->expense)->toHaveCount(1);
});

it('can retrieve a list of expense transactions', function () {
    $data = Expense::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->expense()->create($array);
    }

    expect($user->expense)->toHaveCount(5);
});

it('can retrieve the from piggy bank from the expense transaction', function () {
    $expense = Expense::factory()->create();

    expect($expense->from)->toBeInstanceOf(App\Models\PiggyBank::class);
});

it('can retrieve the to piggy bank from the expense transaction', function () {
    $expense = Expense::factory()->create();

    expect($expense->to)->toBeInstanceOf(App\Models\PiggyBank::class);
});
