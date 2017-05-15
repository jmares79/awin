<?php

namespace ReportBundle\Service;

use ReportBundle\Interfaces\OutputReportInterface;

class OutputPrinterService implements OutputReportInterface
{
    public function show()
    {
        var_dump("Creating report from ReportService");
    }
}
