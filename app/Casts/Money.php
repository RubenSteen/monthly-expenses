<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// https://www.youtube.com/watch?v=VViQBqC8Dbc

class Money implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return \Brick\Money\Money::ofMinor($attributes['amount'], 'EUR');
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if (! $value instanceof \Brick\Money\Money) {
            return Str::remove([',', '.'], $value);
        }

        return $value->getMinorAmount()->toInt();
    }
}
