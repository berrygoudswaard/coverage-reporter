<?php

namespace NoRegression\CoverageReporter\Console;

use NoRegression\CoverageReporter\Command;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct()
    {
        return parent::__construct('CoverageReporter', '0.0.1');
    }

    public function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new Command\ReportCommand();
        return $commands;
    }
}
