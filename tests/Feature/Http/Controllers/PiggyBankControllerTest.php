<?php

use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can view the piggy bank index page when logged in', function () {
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

it('can create a piggy bank', function () {
    $data = PiggyBank::factory()->make()->toArray();

    $count = $this->user->piggyBanks->count();

    actingAs($this->user)
        ->post(route('piggy-bank.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Potje aangemaakt']);

    expect($this->user->fresh()->piggyBanks)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->piggyBanks->last()->name)
        ->toBe($data['name']);
});

/*
|--------------------------------------------------------------------------
| Edit tests
|--------------------------------------------------------------------------
*/

it('can edit a piggy bank', function () {
    $piggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);

    $updatedPiggyBank = PiggyBank::factory()->make()->toArray();

    actingAs($this->user)
        ->put(route('piggy-bank.update', $piggyBank), $updatedPiggyBank)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Potje aangepast']);

    expect($this->user->fresh()->piggyBanks->last()->name)
        ->toBe($updatedPiggyBank['name']);
});

it('cannot edit a piggy bank that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $piggyBank = PiggyBank::factory()->create(['user_id' => $otherUser]);

    $updatedPiggyBank = PiggyBank::factory()->make()->toArray();

    actingAs($this->user)
        ->put(route('piggy-bank.update', $piggyBank), $updatedPiggyBank)
        ->assertStatus(403);

    expect($piggyBank->fresh()->name)
        ->toBe($piggyBank->name);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = PiggyBank::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('piggy-bank.store', $data))
        ->assertSessionHasErrors([
            $field => $rule,
        ]);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
]);

test('validation tests while creating that can be null', function (string $field) {
    $data = PiggyBank::factory()->make([$field => null])->toArray();

    actingAs($this->user)
        ->post(route('piggy-bank.store', $data))
        ->assertSessionHasNoErrors([$field]);
})->with([
    'description' => ['description'],
]);

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

it('can delete a piggy bank', function () {
    PiggyBank::factory()->count(5)->create(['user_id' => $this->user->id]);

    $count = $this->user->piggyBanks->count();

    actingAs($this->user)
        ->delete(route('piggy-bank.delete', $this->user->piggyBanks->first()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Potje verwijderd']);

    expect($this->user->fresh()->piggyBanks)
        ->toHaveCount(($count - 1));
});

it('cannot delete a piggy bank that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $piggyBanks = PiggyBank::factory()->count(5)->create(['user_id' => $this->user->id]);

    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser->id]);

    actingAs($this->user)
        ->delete(route('piggy-bank.delete', $otherPiggyBank))
        ->assertStatus(403);
});
