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

    protected $header;
    protected $converter;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Fetches the transaction from a file source, returning a list of them
     *
     * @param $merchantId The Id of the merchant to be retrieved
     *
     * @return The fecthed & converted transactions
     */
    public function fetchTransactions($merchantId = null)
    {
        return $this->parseTransactions($merchantId);
    }

    /**
     * Parses the transactions data file and prepares it to be shown
     *
     * @param int $merchantId
     *
     * @throws FileParsingException on file error
     * @return An array with the converted transactions
     */
    protected function parseTransactions($merchantId = null)
    {
        if (!$handler = fopen(self::TRANSACTION_FILE, 'r')) throw new FileParsingException();

        $convertedTransactions = [];

        $this->parseHeader($handler);

        while ($row = fgetcsv($handler)) {
            $transaction = $this->parseRow($row);

            if ($transaction[0] == $merchantId) {
                $convertedTransactions[] = $this->prepareTransaction($transaction);
            }
        }

        return $convertedTransactions;
    }

    /**
     * Parses the header of the stream
     *
     * @param mixed $streamHandler
     *
     * @return An array with the header data
     */
    protected function parseHeader($row)
    {
        $headerRow = fgetcsv($row);
        $this->header = $this->parseRow($headerRow);
    }

    /**
     * Parses a common row of the stream
     *
     * @param mixed $row
     *
     * @return An array with the row data
     */
    protected function parseRow($row)
    {
        return explode(";", str_replace("\"", "", $row[0]));
    }

    /**
     * Prepares the transaction by converting the amount to the base currency
     *
     * @param mixed $transaction
     *
     * @return An array with the converted transactions
     */
    protected function prepareTransaction($transaction)
    {
        list($id, $date, $amount) = $transaction;

        return [$id, $date, $this->converter->convert($amount)];
    }
}
