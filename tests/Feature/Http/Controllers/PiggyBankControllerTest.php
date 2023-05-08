<?php

use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\{actingAs};

beforeEach(function () {
    $this->user = User::factory()->create();
});

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
