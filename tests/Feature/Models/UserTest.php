<?php

use App\Models\Category;
use App\Models\Income;
use App\Models\PiggyBank;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\{actingAs};

beforeEach(function () {
    $this->user = User::factory()->create();
});

/*
|--------------------------------------------------------------------------
| Last Activity tests
|--------------------------------------------------------------------------
*/

it('updates the last_activity record when a user makes a request', function () {
    $user = User::factory()->create(); // Observer 'creating' bypass
    $user->last_activity = now()->subDay();
    $user->save();

    actingAs($user)
        ->get('/')
        ->assertStatus(200);

    expect(Carbon::parse($user->fresh()->last_activity)->diffInMinutes(now()))
        ->toBe(0);
});

/*
|--------------------------------------------------------------------------
| Piggy Bank tests
|--------------------------------------------------------------------------
*/

it('can create a piggy bank', function () {
    $data = PiggyBank::factory()->make()->toArray();

    $user = User::factory()->create();

    $user->piggyBanks()->create($data);

    expect($user->piggyBanks)->toHaveCount(2);
});

it('can retrieve a list of piggy banks', function () {
    $data = PiggyBank::factory()->count(5)->make()->toArray();

    $user = User::factory()->create();

    foreach ($data as $array) {
        $user->piggyBanks()->create($array);
    }

    expect($user->piggyBanks)->toHaveCount(6);
});

it('when a user gets deleted their piggybanks gets deleted', function () {
    $user = User::factory()->create();

    $user_id = $user->id;

    PiggyBank::factory()->create(['user_id' => $user_id]);

    expect(PiggyBank::where('user_id', $user_id)->get())->toHaveCount(2);

    $user->delete();

    expect(PiggyBank::where('user_id', $user_id)->get())->toHaveCount(0);
});

it('every new user automaticly gets 1 piggy bank named eigen rekening', function () {
    $user = User::factory()->create();

    expect($user->piggyBanks)->toHaveCount(1);
});

/*
|--------------------------------------------------------------------------
| Income tests
|--------------------------------------------------------------------------
*/

it('when a user gets deleted their income gets deleted', function () {
    $user = User::factory()->create();

    $user_id = $user->id;

    Income::factory()->count(2)->create(['user_id' => $user_id]);

    expect(Income::where('user_id', $user_id)->get())->toHaveCount(2);

    $user->delete();

    expect(Income::where('user_id', $user_id)->get())->toHaveCount(0);
});

/*
|--------------------------------------------------------------------------
| Category tests
|--------------------------------------------------------------------------
*/

it('can create a category', function () {
    $count = $this->user->category->count();

    $data = Category::factory()->make()->toArray();

    $this->user->category()->create($data);

    expect($this->user->fresh()->category)->toHaveCount(($count + 1));
});

it('can retrieve a list of categories', function () {
    expect($this->user->category->count())->toBeGreaterThan(0);
});

it('when a user gets deleted their catergories gets deleted', function () {
    expect($this->user->category->count())->toBeGreaterThan(0);

    $this->user->delete();

    expect(Category::where('user_id', $this->user->id)->get())->toHaveCount(0);
});

it('new user gets default categories', function (string $name) {
    expect($name)->toBeIn($this->user->category->pluck('name'));
})->with([
    'default 1' => ['Uitgaven'],
    'default 2' => ['Gezamelijke uitgaven'],
    'default 3' => ['Sparen'],
    'default 4' => ['Gezamelijk sparen'],
]);
