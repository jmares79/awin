<?php

namespace CurrencyBundle\Service;

use CurrencyBundle\Interfaces\CurrencyExchangeRateInterface;

/**
 *  Class for implementing a static currency exchange rate to GBP, took from Google finance at the date of the test
 */
class StaticCurrencyExchangeRateService implements CurrencyExchangeRateInterface
{
    /**
     * @var The static hardcoded rates took from Google finance in the format USD = 0.77 * GBP
     */
    protected $rates = [
        '$' => ['symbol' => 'USD', 'rate' => 0.77],
        '£' => ['symbol' => 'GBP', 'rate' => 1],
        '€' => ['symbol' => 'EUR', 'rate' => 0.85]
    ];

    /**
     * Implements the mandatory method for fetch a currency rate exchange
     *
     * @param string $amount
     * @return A transaction with converted currency amounts
     */
    public function getExchangeRate($currency)
    {
        return $this->rates[$currency];
    }
}
