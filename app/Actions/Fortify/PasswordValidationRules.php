<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\App;
use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules()
    {
        if (! App::environment('local')) {
            return (new Password)->length(10)->requireUppercase()->requireNumeric()->requireSpecialCharacter();
        }

        return ['required', 'string', new Password, 'confirmed'];
    }
}
