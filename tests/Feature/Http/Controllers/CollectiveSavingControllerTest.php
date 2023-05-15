<?php

use App\Models\CollectiveSaving;
use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->firstPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
    $this->secondPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
});

it('can view the collective saving index page when logged in', function () {
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

it('can create a collective saving transaction', function () {
    $data = CollectiveSaving::factory()->make([
        'from_id' => $this->firstPiggyBank->id,
        'to_id' => $this->secondPiggyBank->id,
    ])->toArray();

    // https://laracasts.com/discuss/channels/laravel/disabling-casts-when-using-factorymake?page=1&replyId=887987
    $data = array_merge($data, [
        'amount' => 1000,
    ]);

    $count = $this->user->collectiveSaving->count();

    actingAs($this->user)
        ->post(route('collective-saving.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Gezamelijke spaardoel aangemaakt']);

    expect($this->user->fresh()->collectiveSaving)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->collectiveSaving->last()->name)
        ->toBe($data['name']);
});

it('cannot create a collective saving transaction with a piggy bank that isnt theirs', function (string $field) {
    $otherUser = User::factory()->create();
    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser->id]);

    $data = CollectiveSaving::factory()->make([$field => $otherPiggyBank->id, 'user_id' => $this->user->id])->toArray();

    actingAs($this->user)
        ->post(route('collective-saving.store', $data))
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

it('can edit a collective saving transaction', function () {
    $collectiveSaving = CollectiveSaving::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $modifiedCollectiveSaving = CollectiveSaving::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('collective-saving.update', $collectiveSaving), $modifiedCollectiveSaving)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Gezamelijke spaardoel aangepast']);

    expect($this->user->fresh()->collectiveSaving->first()->name)
        ->toBe($modifiedCollectiveSaving['name']);
});

it('cannot edit a collective saving transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $collectiveSaving = CollectiveSaving::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $modifiedCollectiveSaving = CollectiveSaving::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('collective-saving.update', $collectiveSaving), $modifiedCollectiveSaving)
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou gezamelijke spaardoel vriend']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = CollectiveSaving::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('collective-saving.store', $data))
        ->assertSessionHasErrors([
            $field => $rule,
        ]);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
]);

test('validation tests while creating amount cannot be null', function () {
    $data = CollectiveSaving::factory()->make()->toArray();

    // https://laracasts.com/discuss/channels/laravel/disabling-casts-when-using-factorymake?page=1&replyId=887987
    $data['amount'] = null;

    actingAs($this->user)
        ->post(route('collective-saving.store', $data))
        ->assertSessionHasErrors([
            'amount' => 'The amount field is required.',
        ]);
});

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

it('can delete a collective saving transaction', function () {
    CollectiveSaving::factory()->count(5)->create(['user_id' => $this->user->id]);

    $count = $this->user->collectiveSaving->count();

    actingAs($this->user)
        ->delete(route('collective-saving.delete', $this->user->collectiveSaving->first()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Gezamelijke spaardoel verwijderd']);

    expect($this->user->fresh()->collectiveSaving)
        ->toHaveCount(($count - 1));
});

it('cannot delete a collective saving transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $otherCollectiveSaving = CollectiveSaving::factory()->create(['user_id' => $otherUser->id]);

    actingAs($this->user)
        ->delete(route('collective-saving.delete', $otherCollectiveSaving))
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou gezamelijke spaardoel vriend']);
});
