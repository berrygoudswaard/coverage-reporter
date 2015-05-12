<?php

namespace BerryGoudswaard\CoverageReporter\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReportCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('coverage:report')
            ->setDescription('Process the coverage')
            ->addArgument(
                'report',
                InputArgument::REQUIRED,
                'Path to the clover coverage report'
            )
            ->addOption(
                'minimum',
                'm',
                InputOption::VALUE_OPTIONAL,
                'The minimum accepted code coverage (percentage)'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reportFile = $input->getArgument('report');
        $minimum = $input->getOption('minimum');

        if (!file_exists($reportFile)) {
            throw new \Exception(sprintf('The file %s does not exist', $reportFile));
        }

        if (empty($minimum) || !($percentage = min(100, max(0, (int) $minimum)))) {
            $percentage = 0;
        }

        $xml = new \SimpleXMLElement(file_get_contents($reportFile));
        $metrics = $xml->xpath('//metrics');
        $totalElements = 0;
        $checkedElements = 0;

        foreach ($metrics as $metric) {
            $totalElements += (int) $metric['elements'];
            $checkedElements += (int) $metric['coveredelements'];
        }

        $coverage = ($checkedElements / $totalElements) * 100;

        if ($coverage < $percentage) {
            $output->writeln(
                sprintf(
                    '<error>%.2f%% covered. This is below the accepted percentage (%.2f%%)</error>',
                    $coverage,
                    $percentage
                )
            );
            return 1;
        }

        $output->writeln(sprintf('<info>%.2f%% covered.</info>'  . PHP_EOL, $coverage));
    }
}
