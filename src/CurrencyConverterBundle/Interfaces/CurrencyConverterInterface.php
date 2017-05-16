<?php

namespace CurrencyConverterBundle\Interfaces;

interface CurrencyConverterInterface
{
    public function convert($amount, $currency);
}
