<?php

use Brick\Money\Money;
use Illuminate\Support\Str;

if (! function_exists('money')) {
    function money($object)
    {
        return [
            'value' => $object->getMinorAmount(),
            'valueSeperatedCents' => Str::replace('.', ',', $object->getAmount()),
            'valueDisplay' => $object->formatTo('nl_NL'),
        ];
    }
}

if (! function_exists('moneyDisplay')) {
    function moneyDisplay($object)
    {
        return money($object)['valueDisplay'];
    }
}

// Add zero's if the cents in a euro are not specified
if (! function_exists('correctAmount')) {
    function correctAmount($amount)
    {
        if (preg_match('/(,\d\d)$/', $amount) > 0) {

        } elseif (preg_match('/(,\d)$/', $amount) > 0) {
            $amount .= '0';
        } else {
            $amount .= '00';
        }

        return ['amount' => $amount];
    }
}

if (! function_exists('calculateLeftoverBudget')) {
    function calculateLeftoverBudget($user = null)
    {
        if (is_null($user)) {
            $user = \Auth::user();
        }

        $budget = Money::of(0, 'EUR')
            ->plus($user->total_income_amount);

        foreach ($user->category as $category) {
            $budget = $budget->minus($category->amount);
        }

        return moneyDisplay($budget);
    }
}
