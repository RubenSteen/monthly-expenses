<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('Category/Create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = Auth::user()->category()->create($request->validated());

        return Redirect::route('category.show', $category->id)->with(['success' => 'Categorie aangemaakt']);
    }

    public function show(Category $category)
    {
        if (Auth::user()->id !== $category->user_id) {
            abort(403);
        }

        return Inertia::render('Category/Show', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'transaction' => $category->transaction()->orderBy('amount')->get()
                    ->transform(function ($category) {
                        return [
                            'id' => $category->id,
                            'from' => $category->from->only(['id', 'name', 'description']),
                            'to' => $category->to->only(['id', 'name', 'description']),
                            'name' => $category->name,
                            'amount' => money($category->amount),
                        ];
                    }),
            ],
            'piggyBanks' => Auth::user()->piggyBanks,
        ]);
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

        return Redirect::route('dashboard')->with('success', 'Categorie verwijderd');
    }
}
