<?php

use App\Models\CollectiveExpense;
use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->firstPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
    $this->secondPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
});

it('can view the collective expense index page when logged in', function () {
    actingAs($this->user)
        ->get(route('piggy-bank.index'))
        ->assertStatus(200);
});

// it('canot view the piggy bank index page as a guest', function () {
//     get(route('piggy-bank.index'))
//         ->assertStatus(302);
// });

/*
|--------------------------------------------------------------------------
| Create tests
|--------------------------------------------------------------------------
*/

it('can create a collective expense transaction', function () {
    $data = CollectiveExpense::factory()->make([
        'from_id' => $this->firstPiggyBank->id,
        'to_id' => $this->secondPiggyBank->id,
    ])->toArray();

    $count = $this->user->collectiveExpense->count();

    actingAs($this->user)
        ->post(route('collective-expense.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Gezamelijke uitgaven aangemaakt']);

    expect($this->user->fresh()->collectiveExpense)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->collectiveExpense->last()->name)
        ->toBe($data['name']);
});

it('cannot create a collective expense transaction with a piggy bank that isnt theirs', function (string $field) {
    $otherUser = User::factory()->create();
    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser->id]);

    $data = CollectiveExpense::factory()->make([$field => $otherPiggyBank->id, 'user_id' => $this->user->id])->toArray();

    actingAs($this->user)
        ->post(route('collective-expense.store', $data))
        ->assertStatus(302)
        ->assertSessionHasErrors([$field => 'Dit is niet jou potje vriend']);
})->with([
    'from' => ['from_id'],
    'to' => ['to_id'],
]);

/*
|--------------------------------------------------------------------------
| Edit tests
|--------------------------------------------------------------------------
*/

it('can edit a collective expense transaction', function () {
    $collectiveExpense = CollectiveExpense::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $modifiedCollectiveExpense = CollectiveExpense::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('collective-expense.update', $collectiveExpense), $modifiedCollectiveExpense)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Gezamelijke uitgaven aangepast']);

    expect($this->user->fresh()->collectiveExpense->first()->name)
        ->toBe($modifiedCollectiveExpense['name']);
});

it('cannot edit a collective expense transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $collectiveExpense = CollectiveExpense::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $modifiedCollectiveExpense = CollectiveExpense::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('collective-expense.update', $collectiveExpense), $modifiedCollectiveExpense)
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou gezamelijke uitgaven vriend']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = CollectiveExpense::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('collective-expense.store', $data))
        ->assertSessionHasErrors([
            $field => $rule,
        ]);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
    'amount cannot be null' => ['amount', null, 'The amount field is required.'],
]);

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

it('can delete a collective expense transaction', function () {
    CollectiveExpense::factory()->count(5)->create(['user_id' => $this->user->id]);

    $count = $this->user->collectiveExpense->count();

    actingAs($this->user)
        ->delete(route('collective-expense.delete', $this->user->collectiveExpense->first()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Gezamelijke uitgaven verwijderd']);

    expect($this->user->fresh()->collectiveExpense)
        ->toHaveCount(($count - 1));
});

it('cannot delete a collective expense transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $otherCollectiveExpense = CollectiveExpense::factory()->create(['user_id' => $otherUser->id]);

    actingAs($this->user)
        ->delete(route('collective-expense.delete', $otherCollectiveExpense))
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou gezamelijke uitgaven vriend']);
});
