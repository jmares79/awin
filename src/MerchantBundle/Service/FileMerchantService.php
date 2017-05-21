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

    protected $handler;
    protected $header;
    protected $converter;
    protected $transactions;
    protected $converted;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
        $this->getHandler();
    }

    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Fetches the transaction from a file source, returning a list of them
     *
     * @param int $merchantId
     *
     * @throws FileParsingException on file error
     * @return An array with the converted transactions
     */
    public function fetchTransactions($merchantId = null)
    {
        $transactions = [];

        $this->parseHeader();

        while ($row = fgetcsv($this->handler)) {
            $transaction = $this->parseRow($row);

            if ($transaction[0] == $merchantId) {
                $this->transactions[] = $transaction;
            }
        }
    }

    /**
     * Prepares the transactions by converting the amount to the base currency
     *
     * @param internal $transactions
     *
     * @return An array with the converted transactions
     */
    public function prepareTransactions()
    {
        $converted = [];

        foreach ($this->transactions as $transaction) {
            list($id, $date, $amount) = $transaction;

            $this->converted[] = [$id, $date, $this->converter->convert($amount)];
        }
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function getConvertedTransactions()
    {
        return $this->converted;
    }

    protected function getHandler()
    {
        if (!$this->handler = fopen(self::TRANSACTION_FILE, 'r')) throw new FileParsingException();
    }

    /**
     * Parses the header of the stream
     *
     * @return An array with the header data
     */
    protected function parseHeader()
    {
        $headerRow = fgetcsv($this->handler);
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
}
