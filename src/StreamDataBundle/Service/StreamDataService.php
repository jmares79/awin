<?php

namespace StreamDataBundle\Service;

use MerchantBundle\Exceptions\FileParsingException;
use StreamDataBundle\Interfaces\StreamDataInterface;

/**
 *  Class for implementing a stream data fetcher
 */
class StreamDataService implements StreamDataInterface
{
    const READ_MODE = 'r';

    protected $streamDirectory;
    protected $streamName;
    protected $streamSource;
    protected $handler;
    protected $data;

    public function __construct($streamDirectory, $streamName)
    {
        $this->streamDirectory = $streamDirectory;
        $this->streamName = $streamName;
    }

    public function setStreamDirectory($dir)
    {
        $this->setStreamDirectory = $dir;
    }

    public function setStreamPath($path)
    {
        $this->setStreamPath = $path;
    }

    public function fetchData($merchantId)
    {
        $this->openStream();

        $this->parseHeader();
        $data = $this->getData($merchantId);

        $this->closeStream();

        return $data;
    }

    protected function getData($merchantId)
    {
        while ($row = $this->getStreamRow()) {
            $transaction = $this->parseRow($row);

            if ($transaction[0] == $merchantId) {
                $this->transactions[] = $transaction;
            }
        }

        return [
            'header' => $this->header,
            'transactions' => $this->transactions
        ];
    }

    /**
     * Parses and return a row of the stream
     *
     * @return An array with the row data
     */
    protected function getStreamRow()
    {
        return fgetcsv($this->handler);
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

    protected function openStream()
    {
        if (!$this->handler = fopen($this->getFullPath(), self::READ_MODE)) throw new FileParsingException();
    }

    protected function closeStream()
    {
        fclose($this->handler);
    }

    protected function getFullPath()
    {
        return $this->streamDirectory . $this->streamName;
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
