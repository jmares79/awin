<?php

namespace StreamDataBundle\Service;

use MerchantBundle\Exceptions\FileParsingException;
use StreamDataBundle\Interfaces\StreamDataInterface;
use StreamDataBundle\Interfaces\FileReaderInterface;

/**
 *  Class for implementing a stream data fetcher
 */
class StreamDataService implements StreamDataInterface
{
    protected $reader;

    public function __construct(FileReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    public function fetchData($merchantId)
    {
        $this->reader->openStream();
        $this->reader->parseHeader();

        $data = $this->getData($merchantId);

        $this->reader->closeStream();

        return $data;
    }

    protected function getData($merchantId)
    {
        while ($row = $this->reader->getFileRow()) {
            $transaction = $this->reader->parseRow($row);

            if ($transaction[0] == $merchantId) {
                $this->transactions[] = $transaction;
            }
        }

        return [
            'header' => $this->reader->getHeader(),
            'transactions' => $this->transactions
        ];
    }
}
