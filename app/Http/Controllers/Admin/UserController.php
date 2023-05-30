<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/User/Index', [
            'users' => User::all()
                ->transform(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'profile_photo_url' => $user->profilePhotoUrl,
                    'email_verified_at' => $user->email_verified_at,
                    'admin' => $user->isAdmin(),
                    'super_admin' => $user->isSuperAdmin(),
                    'last_activity' => $user->last_activity,
                    'created_at' => $user->created_at,
                ]),
        ]);
    }
}
