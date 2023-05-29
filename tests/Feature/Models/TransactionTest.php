<?php

use App\Models\Transaction;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->category = $this->user->category->first();
});

it('can create a transaction', function () {
    $data = Transaction::factory()->make()->toArray();

    $this->category->transaction()->create($data);

    expect($this->category->fresh()->transaction)->toHaveCount(1);
});

it('can retrieve a list of transactions', function () {
    $data = Transaction::factory()->count(5)->make()->toArray();

    foreach ($data as $array) {
        $this->category->transaction()->create($array);
    }

    expect($this->category->fresh()->transaction)->toHaveCount(5);
});

it('can retrieve the from category from the transaction', function () {
    $transaction = Transaction::factory()->create();

    expect($transaction->category)->toBeInstanceOf(App\Models\Category::class);
});

it('can retrieve the from piggy bank from the transaction', function () {
    $transaction = Transaction::factory()->create();

    expect($transaction->from)->toBeInstanceOf(App\Models\PiggyBank::class);
});

it('can retrieve the to piggy bank from the transaction', function () {
    $transaction = Transaction::factory()->create();

    expect($transaction->to)->toBeInstanceOf(App\Models\PiggyBank::class);
});
