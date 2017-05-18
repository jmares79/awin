<?php

namespace MerchantBundle\Service;

use MerchantBundle\Interfaces\TransactionFetcherInterface;
use MerchantBundle\Exceptions\FileParsingException;
use CurrencyBundle\Interfaces\CurrencyConverterInterface;

/**
 * Service that fetches transactions from a CSV file
 */
class FileMerchantService implements TransactionFetcherInterface
{
    //TODO send this to config by default OR an optional parameter
    const TRANSACTION_FILE = 'data/data.csv';

    protected $converter;
    protected $convertedTransactions;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Fetches the transaction from a file source, returning a list of transactions
     *
     * @param $merchantId The Id of the merchant to be retrieved
     * @return Fills the internal attribute transactions
     */
    public function fetchTransactions($merchantId = null)
    {
        $this->transactions = $this->parseTransactions($merchantId);
        print_r($this->transactions);
    }

    /**
     * Parses the transactions data file and prepares the transactions to be shown
     *
     * @param int $merchantId
     * @throws FileParsingException on file error
     * @return An array with the converted transactions
     */
    protected function parseTransactions($merchantId = null)
    {
        if (!$handle = fopen(self::TRANSACTION_FILE, 'r')) throw new FileParsingException();

        $header = fgetcsv($handle);

        while ($row = fgetcsv($handle)) {
            $transaction = explode(";", str_replace("\"", "", $row[0]));

            if ($transaction[0] == $merchantId) {
                $this->convertedTransactions[] = $this->prepareTransaction($transaction);
            }
        }
    }

    /**
     * Prepares the transaction by converting the amount to the base currency
     *
     * @param mixed $transaction
     * @return An array with the converted transactions
     */
    protected function prepareTransaction($transaction)
    {
        list($id, $date, $amount) = $transaction;

        return [$id, $date, $this->converter->convert($amount)];
    }
}
