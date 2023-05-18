<?php

use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can create a category transaction', function () {
    $count = $this->user->category->count();

    $data = Category::factory()->make()->toArray();

    $this->user->category()->create($data);

    expect($this->user->fresh()->category)->toHaveCount(($count + 1));

    expect($this->user->fresh()->category->last()->name)->toBe($data['name']);
});

it('can retrieve the user linked to the category', function () {
    expect(Category::first()->user->id)->toBe($this->user->id);
});
