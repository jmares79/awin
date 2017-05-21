<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReportServiceTest extends WebTestCase
{
    protected static $container;
    protected static $outputPrinter;
    protected static $merchantService;

    public static function setUpBeforeClass()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        self::$outputPrinter = self::$container->get('output_printer_service');
        self::$merchantService = self::$container->get('transaction_merchant_service');
    }

    public function testCreateReport($transactions, $expected)
    {
        $actual = $this->calculator->performCalculation($string);

        $this->assertEquals($expected, $actual);
    }

    /**
     *  Fake data to provide to the create report test
     */
    public function createReportData()
    {
        return array(
            array(
                "Based on your input, get a random alpha numeric string random.",
                array(
                    "Based" => 1,
                    "on" => 1,
                    "your" => 1,
                    "input" => 1,
                    "get" => 1,
                    "a" => 1,
                    "random" => 2,
                    "alpha" => 1,
                    "numeric" => 1,
                    "string" => 1
                )
            )
        );
    }
}
