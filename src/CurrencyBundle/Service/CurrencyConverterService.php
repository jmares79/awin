<?php

namespace CurrencyBundle\Service;

use CurrencyBundle\Interfaces\CurrencyConverterInterface;

class CurrencyConverterService implements CurrencyConverterInterface
{
    /**
     * Converts an amount on a certain currency to GBP
     *
     * @return A transaction with converted currency amounts
     */
    public function convert($amount, $currency)
    {
        var_dump("Creating report from ReportService");
    }
}
