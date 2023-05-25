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
        ->assertStatus(302)
        ->assertSessionHasErrors([$field => 'Ongeldig potje']);

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
        ->toBe($transaction->getUser()->id);

    $data = modifiedTransaction($transaction->getUser());

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

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = modifiedTransaction($this->user, [$field => $value]);

    actingAs($this->user)
        ->post(route('transaction.store', $this->category), $data)
        ->assertSessionHasErrors([
            $field => $rule,
        ]);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
    'amount cannot be null' => ['amount', null, 'The amount field is required.'],
]);

test('validation tests while updating', function (string $field, mixed $value, string $rule) {
    $transaction = $this->category->transaction->firstOrFail();

    $data = modifiedTransaction($this->user, [$field => $value]);

    actingAs($this->user)
        ->put(route('transaction.update', $transaction), $data)
        ->assertSessionHasErrors([
            $field => $rule,
        ]);

    expect($transaction->fresh()->$field)
        ->not
        ->toBe($value);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
    'amount cannot be null' => ['amount', null, 'The amount field is required.'],
]);

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

it('can delete a transaction', function () {
    $count = $this->category->transaction->count();

    actingAs($this->user)
        ->delete(route('transaction.delete', $this->category->transaction->random()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Transactie verwijderd']);

    expect($this->category->fresh()->transaction)
        ->toHaveCount(($count - 1));
});

it('cannot delete a transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $category = $otherUser->category->first();

    $otherTransaction = Transaction::factory()->create(['category_id' => $category]);

    $count = $category->transaction->count();

    actingAs($this->user)
        ->delete(route('transaction.delete', $otherTransaction))
        ->assertStatus(403);

    expect($category->fresh()->transaction)
        ->toHaveCount($count);
});
