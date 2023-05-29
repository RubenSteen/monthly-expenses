<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => ! Auth::check() ? null : [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'profile_photo_url' => Auth::user()->profilePhotoUrl,
                    'categories' => Auth::user()->category()->orderByDesc('created_at')->get()
                        ->transform(function ($category) {
                            return [
                                'id' => $category->id,
                                'name' => $category->name,
                                'amount' => money($category->amount),
                                'href' => route('category.show', $category),
                                'current' => request()->is(Str::after(route('category.show', $category, false), '/')),
                            ];
                        }),
                ],
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy())->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
