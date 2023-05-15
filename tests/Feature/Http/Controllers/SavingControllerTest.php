<?php

use App\Models\PiggyBank;
use App\Models\Saving;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->firstPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
    $this->secondPiggyBank = PiggyBank::factory()->create(['user_id' => $this->user->id]);
});

it('can view the saving index page when logged in', function () {
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

it('can create a saving transaction', function () {
    $data = Saving::factory()->make([
        'from_id' => $this->firstPiggyBank->id,
        'to_id' => $this->secondPiggyBank->id,
    ])->toArray();

    // https://laracasts.com/discuss/channels/laravel/disabling-casts-when-using-factorymake?page=1&replyId=887987
    $data = array_merge($data, [
        'amount' => 1000,
    ]);

    $count = $this->user->savings->count();

    actingAs($this->user)
        ->post(route('saving.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Spaardoel aangemaakt']);

    expect($this->user->fresh()->savings)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->savings->last()->name)
        ->toBe($data['name']);
});

it('cannot create a saving transaction with a piggy bank that isnt theirs', function (string $field) {
    $otherUser = User::factory()->create();
    $otherPiggyBank = PiggyBank::factory()->create(['user_id' => $otherUser->id]);

    $data = Saving::factory()->make([$field => $otherPiggyBank->id, 'user_id' => $this->user->id])->toArray();

    actingAs($this->user)
        ->post(route('saving.store', $data))
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

it('can edit a saving transaction', function () {
    $saving = Saving::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $modifiedSaving = Saving::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('saving.update', $saving), $modifiedSaving)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Spaardoel aangepast']);

    expect($this->user->fresh()->savings->first()->name)
        ->toBe($modifiedSaving['name']);
});

it('cannot edit a saving transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $saving = Saving::factory()->create([
        'user_id' => $otherUser->id,
    ]);

    $modifiedSaving = Saving::factory()->make([
        'user_id' => $this->user->id,
    ])->toArray();

    actingAs($this->user)
        ->put(route('saving.update', $saving), $modifiedSaving)
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou spaardoel vriend']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = Saving::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('saving.store', $data))
        ->assertSessionHasErrors([
            $field => $rule,
        ]);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
]);

test('validation tests while creating amount cannot be null', function () {
    $data = Saving::factory()->make()->toArray();

    // https://laracasts.com/discuss/channels/laravel/disabling-casts-when-using-factorymake?page=1&replyId=887987
    $data['amount'] = null;

    actingAs($this->user)
        ->post(route('saving.store', $data))
        ->assertSessionHasErrors([
            'amount' => 'The amount field is required.',
        ]);
});

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

it('can delete a saving transaction', function () {
    Saving::factory()->count(5)->create(['user_id' => $this->user->id]);

    $count = $this->user->savings->count();

    actingAs($this->user)
        ->delete(route('saving.delete', $this->user->savings->first()))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Spaardoel verwijderd']);

    expect($this->user->fresh()->savings)
        ->toHaveCount(($count - 1));
});

it('cannot delete a saving transaction that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $otherSaving = Saving::factory()->create(['user_id' => $otherUser->id]);

    actingAs($this->user)
        ->delete(route('saving.delete', $otherSaving))
        ->assertStatus(302)
        ->assertSessionHas(['error' => 'Dit is niet jou spaardoel vriend']);
});
