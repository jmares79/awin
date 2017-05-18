<?php

namespace ReportBundle\Service;

use ReportBundle\Interfaces\OutputReportInterface;
use MerchantBundle\Interfaces\TransactionFetcherInterface;

class ReportService
{
    protected $outputPrinter;
    protected $merchantService;

    public function __construct(
        OutputReportInterface $outputPrinter,
        TransactionFetcherInterface $merchantService
    )
    {
        $this->outputPrinter = $outputPrinter;
        $this->merchantService = $merchantService;
    }

    public function createReport($merchantId)
    {
        // var_dump("Creating report from ReportService for Merchant $merchantId");
        $this->merchantService->fetchTransactions($merchantId);
    }

    public function printReport()
    {
        // var_dump("Creating report from ReportService");
        $this->outputPrinter->show();
    }
}
