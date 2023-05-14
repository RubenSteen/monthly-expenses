<?php

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
