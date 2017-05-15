<?php

namespace CurrencyConverterBundle\Service;

use CurrencyConverterBundle\Interfaces\CurrencyConverterInterface;

class CurrencyService extends CurrencyConverterInterface
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Converts an amount to GBP",
     *
     * @return Response
     */
    public function convert($amount)
    {
        var_dump("Creating report from ReportService");
    }
}
