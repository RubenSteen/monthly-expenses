<?php

use App\Models\Category;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();

    $this->categories = Category::factory()->count(10)->create(['user_id' => $this->user->id]);
});

it('can create a category transaction', function () {
    $data = Category::factory()->make()->toArray();

    $this->user->category()->create($data);

    expect($this->user->category)->toHaveCount(($this->categories->count() + 1));

    expect($this->user->category->last()->name)->toBe($data['name']);
});

it('can retrieve the user linked to the category', function () {
    expect($this->categories->first()->user->id)->toBe($this->user->id);
});
