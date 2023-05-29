<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "deleting" event.
     */
    public function deleting(Category $category): void
    {
        foreach ($category->transaction as $object) {
            $object->delete();
        }
    }
}
