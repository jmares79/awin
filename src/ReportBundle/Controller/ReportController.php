<?php

namespace ReportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReportController extends Controller
{
    public function reportAction($merchantId)
    {
        var_dump($merchantId);
    }
}
