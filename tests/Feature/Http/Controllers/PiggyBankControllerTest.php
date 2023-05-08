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
| Create tests > Validation tests
|--------------------------------------------------------------------------
*/

test('name is required to create a piggy bank', function () {
    $data = PiggyBank::factory()->make(['name' => null])->toArray();

    actingAs($this->user)
        ->post(route('piggy-bank.store', $data))
        ->assertSessionHasErrors([
            'name' => 'The name field is required.',
        ]);
});

test('description can be nullable while creating a piggy bank', function () {
    $data = PiggyBank::factory()->make(['description' => null])->toArray();

    actingAs($this->user)
        ->post(route('piggy-bank.store', $data))
        ->assertSessionHasNoErrors([
            'description',
        ]);
});

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
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou potje vriend']);
});
