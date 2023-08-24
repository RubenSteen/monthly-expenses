<?php

use App\Models\Category;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();

    Category::factory(['user_id' => $this->user->id])->count(10)->create();
});

/*
|--------------------------------------------------------------------------
| Show tests
|--------------------------------------------------------------------------
*/

it('can view the category show page when logged in', function () {
    actingAs($this->user)
        ->get(route('category.show', $this->user->category->first()))
        ->assertStatus(200);
});

/*
|--------------------------------------------------------------------------
| Create tests
|--------------------------------------------------------------------------
*/

it('can create a category', function () {
    $data = Category::factory()->make()->toArray();

    $count = $this->user->category->count();

    actingAs($this->user)
        ->post(route('category.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Categorie aangemaakt']);

    expect($this->user->fresh()->category)
        ->toHaveCount(($count + 1));

    expect($this->user->fresh()->category->last()->name)
        ->toBe($data['name']);
});

it('cannot create a category for another user', function () {
    $count = $this->user->category->count();

    $otherUser = User::factory()->create();

    $data = Category::factory()->make(['user_id' => $otherUser->id])->toArray();

    actingAs($this->user)
        ->post(route('category.store', $data))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Categorie aangemaakt']);

    expect($this->user->fresh()->category)
        ->toHaveCount(($count + 1));
});

/*
|--------------------------------------------------------------------------
| Edit tests
|--------------------------------------------------------------------------
*/

it('can edit a category', function () {
    $category = $this->user->category->first();

    $updatedCategory = Category::factory()->make()->toArray();

    actingAs($this->user)
        ->put(route('category.update', $category), $updatedCategory)
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Categorie aangepast']);

    expect($category->fresh()->name)
        ->toBe($updatedCategory['name']);
});

it('cannot edit a category that isnt theirs', function () {
    $otherUser = User::factory()->create();

    $category = Category::factory()->create(['user_id' => $otherUser]);

    $updatedCategory = Category::factory()->make()->toArray();

    actingAs($this->user)
        ->put(route('category.update', $category), $updatedCategory)
        ->assertStatus(403);

    expect($category->fresh()->name)
        ->not
        ->toBe($updatedCategory['name']);
});

/*
|--------------------------------------------------------------------------
| Validation tests
|--------------------------------------------------------------------------
*/

test('validation tests while creating', function (string $field, mixed $value, string $rule) {
    $data = Category::factory()->make([$field => $value])->toArray();

    actingAs($this->user)
        ->post(route('category.store', $data))
        ->assertSessionHasErrors([
            $field => $rule,
        ]);
})->with([
    'name cannot be null' => ['name', null, 'The name field is required.'],
]);

/*
|--------------------------------------------------------------------------
| Delete tests
|--------------------------------------------------------------------------
*/

it('can delete a category', function () {
    $category = $this->user->category->first();

    $count = $this->user->category->count();

    actingAs($this->user)
        ->delete(route('category.delete', $category))
        ->assertStatus(302)
        ->assertSessionHas(['success' => 'Categorie verwijderd']);

    expect($this->user->fresh()->category)
        ->toHaveCount(($count - 1));
});

it('cannot delete a category that isnt theirs', function () {
    $count = $this->user->category->count();

    $otherUser = User::factory()->create();

    $otherCategory = Category::factory()->create(['user_id' => $otherUser]);

    actingAs($this->user)
        ->delete(route('category.delete', $otherCategory))
        ->assertStatus(403);

    expect($this->user->fresh()->category)
        ->toHaveCount($count);

    expect($otherCategory->name)
        ->not
        ->toBeNull();
});
