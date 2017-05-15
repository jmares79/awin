<?php

namespace ReportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ReportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
       $this
        ->setName('app:create-report')
        ->addArgument('merchantId', InputArgument::REQUIRED, 'The id of the merchant to be shown.')
        ->setDescription('Creates a new report for merchant transactions.')
        ->setHelp('This command allows you to create a report for printing merchant transactions.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump('executing report');

        $merchantId = $input->getArgument('merchantId');
        $reportService = $this->getContainer()->get('report_service');

        // $reportService->createReport($merchantId);
    }
}
