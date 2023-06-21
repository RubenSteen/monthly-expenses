<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->last_activity = now();
    }

    public function created(User $user): void
    {
        //Create some default categories
        $data = [
            ['name' => 'Uitgaven'],
            ['name' => 'Gezamelijke uitgaven'],
            ['name' => 'Sparen'],
            ['name' => 'Gezamelijk sparen'],
        ];

        foreach ($data as $category) {
            $user->category()->create($category);
        }

        //Create a default PiggyBank if the user does not have one.
        if ($user->piggyBanks()->count() === 0) {
            $user->piggyBanks()->create([
                'name' => 'Eigen rekening',
            ]);
        }
    }

    public function deleting(User $user): void
    {
        foreach ($user->category as $object) {
            $object->delete();
        }

        foreach ($user->income as $object) {
            $object->delete();
        }

        foreach ($user->piggyBanks as $object) {
            $object->delete();
        }
    }
}
