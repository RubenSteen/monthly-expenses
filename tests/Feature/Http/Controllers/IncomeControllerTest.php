<?php

use App\Models\Income;
use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->firstPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
    $this->secondPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
});

it('can view the income index page when logged in', function () {
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

it('can create a income transaction', function () {
    $data = Income::factory()->make([
        'from_id' => $this->firstPiggyBank->id,
        'to_id' => $this->secondPiggyBank->id,
    ])->toArray();

    $count = $this->user->income->count();

    actingAs($this->user)
        ->post(route('income.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Inkomen aangemaakt']);

    expect($this->user->fresh()->income)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->income->last()->name)
        ->toBe($data['name']);
});

it('cannot create a income transaction with a piggy bank that isnt theirs', function (string $field) {
    $otherUser = User::factory()->create();
    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser->id]);

    $data = Income::factory()->make([$field => $otherPiggyBank->id, 'user_id' => $this->user->id])->toArray();

    actingAs($this->user)
        ->post(route('income.store', $data))
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

it('can edit a income transaction', function () {
    $income = Income::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $modifiedIncome = Income::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('income.update', $income), $modifiedIncome)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Inkomen aangepast']);

    expect($this->user->fresh()->income->first()->name)
        ->toBe($modifiedIncome['name']);
});

it('cannot edit a income transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $income = Income::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $modifiedIncome = Income::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('income.update', $income), $modifiedIncome)
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou inkomen vriend']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = Income::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('income.store', $data))
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

it('can delete a income transaction', function () {
    Income::factory()->count(5)->create(['user_id' => $this->user->id]);

    $count = $this->user->income->count();

    actingAs($this->user)
        ->delete(route('income.delete', $this->user->income->first()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Inkomen verwijderd']);

    expect($this->user->fresh()->income)
        ->toHaveCount(($count - 1));
});

it('cannot delete a income transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $otherIncome = Income::factory()->create(['user_id' => $otherUser->id]);

    actingAs($this->user)
        ->delete(route('income.delete', $otherIncome))
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou inkomen vriend']);
});
