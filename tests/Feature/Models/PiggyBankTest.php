<?php

use App\Models\Income;
use App\Models\PiggyBank;
use App\Models\User;
use function Pest\Laravel\{actingAs};

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->piggyBanks = PiggyBank::factory()->count(10)->create(['user_id' => $this->user->id]);

    $this->incomes = Income::factory()->count(10)->create(['user_id' => $this->user->id]);
});

/*
|--------------------------------------------------------------------------
| PiggyBank tests
|--------------------------------------------------------------------------
*/

it('when a piggy bank gets deleted their income gets deleted', function () {
    expect(Income::where('user_id', $this->user->id)->get())->toHaveCount(10);

    $this->user->delete();

    expect(Income::where('user_id', $this->user->id)->get())->toHaveCount(0);
});
