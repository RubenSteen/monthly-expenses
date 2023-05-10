<?php

use App\Models\Expense;
use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->firstPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
    $this->secondPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
});

it('can view the expense index page when logged in', function () {
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

it('can create a expense transaction', function () {
    $data = Expense::factory()->make([
        'from_id' => $this->firstPiggyBank->id,
        'to_id' => $this->secondPiggyBank->id,
    ])->toArray();

    $count = $this->user->expense->count();

    actingAs($this->user)
        ->post(route('expense.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Inkomen aangemaakt']);

    expect($this->user->fresh()->expense)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->expense->last()->name)
        ->toBe($data['name']);
});

it('cannot create a expense transaction with a piggy bank that isnt theirs', function (string $field) {
    $otherUser = User::factory()->create();
    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser->id]);

    $data = Expense::factory()->make([$field => $otherPiggyBank->id, 'user_id' => $this->user->id])->toArray();

    actingAs($this->user)
        ->post(route('expense.store', $data))
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

it('can edit a expense transaction', function () {
    $expense = Expense::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $modifiedExpense = Expense::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('expense.update', $expense), $modifiedExpense)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Inkomen aangepast']);

    expect($this->user->fresh()->expense->first()->name)
        ->toBe($modifiedExpense['name']);
});

it('cannot edit a expense transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $expense = Expense::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $modifiedExpense = Expense::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('expense.update', $expense), $modifiedExpense)
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou uitgaven vriend']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = Expense::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('expense.store', $data))
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

it('can delete a expense transaction', function () {
    Expense::factory()->count(5)->create(['user_id' => $this->user->id]);

    $count = $this->user->expense->count();

    actingAs($this->user)
        ->delete(route('expense.delete', $this->user->expense->first()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Inkomen verwijderd']);

    expect($this->user->fresh()->expense)
        ->toHaveCount(($count - 1));
});

it('cannot delete a expense transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $otherExpense = Expense::factory()->create(['user_id' => $otherUser->id]);

    actingAs($this->user)
        ->delete(route('expense.delete', $otherExpense))
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou uitgaven vriend']);
});
