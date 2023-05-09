<?php

use App\Models\Transaction;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('can create a transaction', function () {
    $data = Transaction::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->income()->create($data);

    expect($user->income)->toHaveCount(1);
});

// it('can retrieve a list of transactions', function () {
//     $data = Transaction::factory()->count(5)->make()->toArray();

//     $user = User::factory()->create();

//     foreach ($data as $array) {
//         $user->income()->create($array);
//     }

//     expect($user->income)->toHaveCount(5);
// });
