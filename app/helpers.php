<?php

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