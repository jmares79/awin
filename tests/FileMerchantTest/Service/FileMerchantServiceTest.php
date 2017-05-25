<?php
use PHPUnit\Framework\TestCase;

use MerchantBundle\Service\FileMerchantService;
use CurrencyBundle\Service\CurrencyConverterService;
use StreamDataBundle\Service\StreamDataService;

class FileMerchantServiceTest extends TestCase
{
    protected $mockedConverter;
    protected $mockedStream;
    protected $merchant;

    public function setUp()
    {
        $this->mockedStream = $this->createMock(StreamDataService::class);
        $this->mockedConverter = $this->createMock(CurrencyConverterService::class);

        $this->mockedStream
            ->method('fetchData')
            ->willReturn(
                array(
                    'header' => array("merchant", "date", "value"),
                    'transactions' => array(
                        array("2", "01/05/2010", "£50.00"),
                        array("2", "01/05/2010", "$66.10"),
                        array("2", "02/05/2010", "€12.00"),
                        array("2", "02/05/2010", "£6.50"),
                        array("2", "04/05/2010", "€6.50"),
                    )
                )
            );

        $this->merchant = new FileMerchantService($this->mockedConverter, $this->mockedStream);
    }

    public function testFetchTransactions()
    {
        $this->merchant->fetchTransactions('2');
        $transactions = $this->merchant->getFetchedTransactions();

        $this->assertCount(5, $transactions);
    }
}
