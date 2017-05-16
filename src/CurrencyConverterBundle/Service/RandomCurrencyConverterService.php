<?php

namespace CurrencyConverterBundle\Service;

use CurrencyConverterBundle\Interfaces\CurrencyConverterInterface;

class RandomCurrencyConverterService extends CurrencyConverterInterface
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Converts an amount on a certain currency to GBP"
     * )
     *
     * @return Response
     */
    public function convert($amount, $currency)
    {
        var_dump("Creating report from ReportService");
    }
}
