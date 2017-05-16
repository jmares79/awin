<?php

namespace ReportBundle\Service;

use ReportBundle\Interfaces\OutputReportInterface;

class ReportService
{
    protected $outputPrinter;

    public function __construct(OutputReportInterface $outputPrinter)
    {
        $this->outputPrinter = $outputPrinter;
    }

    public function createReport($merchantId)
    {
        var_dump("Creating report from ReportService for Merchant $merchantId");
    }

    public function printReport()
    {
        var_dump("Creating report from ReportService");
        $this->outputPrinter->show();
    }
}
