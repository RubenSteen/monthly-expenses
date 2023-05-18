<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Auth::user()->category()->create($request->validated());

        return Redirect::back()->with(['success' => 'Categorie aangemaakt']);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return Redirect::back()->with('success', 'Categorie aangepast');
    }

    public function delete(Category $category): RedirectResponse
    {
        if (Auth::user()->id !== $category->user_id) {
            return abort(403);
        }

        $category->delete();

        return Redirect::back()->with('success', 'Categorie verwijderd');
    }
}
