<?php

use App\Models\Category;
use App\Models\PiggyBank;
use App\Models\Transaction;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->category = $this->user->category->first();

    Transaction::factory()->count(10)->create(['from_id' => $this->user->piggyBanks->first(), 'category_id' => $this->category->id]);

    $this->data = Transaction::factory()->make([
        'from_id' => $this->user->piggyBanks->first(),
        'to_id' => $this->user->piggyBanks->first(),
    ])->toArray();

    // https://laracasts.com/discuss/channels/laravel/disabling-casts-when-using-factorymake?page=1&replyId=887987
    $this->data['amount'] = $this->data['amount']->getMinorAmount()->toInt();
});

/*
|--------------------------------------------------------------------------
| Create tests
|--------------------------------------------------------------------------
*/

it('can create a transaction', function () {
    $count = $this->category->transaction->count();

    actingAs($this->user)
        ->post(route('transaction.store', $this->category), $this->data)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Transactie aangemaakt']);

    expect($this->category->fresh()->transaction)
        ->toHaveCount(($count + 1));

    expect($this->category->fresh()->transaction->last()->name)
        ->toBe($this->data['name']);
});

it('cannot create a transaction with a from piggy bank that isnt theirs', function (string $field) {
    $otherUser = User::factory()->create();
    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser]);

    $this->data[$field] = $otherPiggyBank;

    $count = $this->category->transaction->count();

    actingAs($this->user)
        ->post(route('transaction.store', $this->category), $this->data)
        ->assertStatus(403);

    expect($this->category->fresh()->transaction)
        ->toHaveCount($count);
})->with([
    'to' => ['to_id'],
    'from' => ['from_id'],
]);

it('cannot create a transaction with a category that isnt theirs', function () {
    $otherUser = User::factory()->create();
    $otherCategory = Category::factory()->create(['user_id' => $otherUser]);

    $count = $this->category->transaction->count();
    $otherCategoryCount = $otherCategory->transaction->count();

    actingAs($this->user)
        ->post(route('transaction.store', $otherCategory), $this->data)
        ->assertStatus(403);

    expect($this->category->fresh()->transaction)
        ->toHaveCount($count);

    expect($otherCategory->fresh()->transaction)
        ->toHaveCount($otherCategoryCount);
});

/*
|--------------------------------------------------------------------------
| Edit tests
|--------------------------------------------------------------------------
*/

it('can edit a transaction', function () {
    $data = modifiedTransaction($this->user);
    $transaction = $this->category->transaction->first();

    actingAs($this->user)
        ->put(route('transaction.update', $transaction), $data)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Transactie aangepast']);

    expect($transaction->fresh()->name)
        ->toBe($data['name']);
});

it('cannot edit a transaction that isnt theirs', function () {
    $this->otherUser = User::factory()->create();

    $transaction = Transaction::factory()->create(['category_id' => $this->otherUser->category->first()]);

    expect($this->user->id)
        ->not
        ->toBe($transaction->category->user->id);

    $data = modifiedTransaction($transaction->category->user);

    actingAs($this->user)
        ->put(route('transaction.update', $transaction), $data)
        ->assertStatus(403);

    expect($transaction->fresh()->name)
        ->not
        ->toBe($data['name']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

// test('validation tests while creating', function (string $field, mixed $value, string $rule) {
//     $data = Income::factory()->make([$field => $value])->toArray();

//     actingAs($this->user)
//         ->post(route('income.store', $data))
//         ->assertSessionHasErrors([
//             $field => $rule,
//         ]);
// })->with([
//     'name cannot be null' => ['name', null, 'The name field is required.'],
// ]);

// test('validation tests while creating amount cannot be null', function () {
//     $data = Income::factory()->make()->toArray();

//     // https://laracasts.com/discuss/channels/laravel/disabling-casts-when-using-factorymake?page=1&replyId=887987
//     $data['amount'] = null;

//     actingAs($this->user)
//         ->post(route('income.store', $data))
//         ->assertSessionHasErrors([
//             'amount' => 'The amount field is required.',
//         ]);
// });

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

// it('can delete a income transaction', function () {
//     $count = $this->user->income->count();

//     actingAs($this->user)
//         ->delete(route('income.delete', $this->user->income->first()))
//         ->assertStatus(302)
//         ->assertSessionHas(['success' => 'Inkomen verwijderd']);

//     expect($this->user->fresh()->income)
//         ->toHaveCount(($count - 1));
// });

// it('cannot delete a income transaction that isnt theirs', function () {
//     $otherUser = User::factory()->create();

//     $otherIncome = Income::factory()->create(['user_id' => $otherUser->id]);

//     actingAs($this->user)
//         ->delete(route('income.delete', $otherIncome))
//         ->assertStatus(302)
//         ->assertSessionHas(['error' => 'Dit is niet jou inkomen vriend']);
// });
