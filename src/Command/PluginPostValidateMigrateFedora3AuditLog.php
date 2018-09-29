<?php
// src/Command/PluginPostValidateMigrateFedora3AuditLog.php

/**
 * This Riprap plugin provides a strategy for migrating fixity events from a
 * Fedora 3.x repository. It assumes that resources migrated from Fedora 3.x to
 * Fedora 5+ include the AUDIT datastream. The plugin is not needed after the
 * fixity events in the AUDIT datastreams for all resources have been persisted
 * to Riprap; when this is achieved the plugin can be disabled.
 *
 *
 */
namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Console\Input\ArrayInput;

use Psr\Log\LoggerInterface;

use App\Entity\Event;

class PluginPostValidateMigrateFedora3AuditLog extends ContainerAwareCommand
{
    private $params;

    public function __construct(ParameterBagInterface $params = null, LoggerInterface $logger = null)
    {
        $this->params = $params;

        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:riprap:plugin:postvalidate:migratefedora3auditlog')
            ->setDescription('A Riprap plugin that persists fixity events from a resources\'s ' .
                'Fedora 3.x AUDIT datastream to Riprap.');

        // phpcs:disable
        $this
            ->addOption('timestamp', null, InputOption::VALUE_REQUIRED, 'ISO 8601 date when the fixity validation event occured.')
            ->addOption('resource_id', null, InputOption::VALUE_REQUIRED, 'Fully qualifid URL of the resource to validate.')
            ->addOption('event_uuid', null, InputOption::VALUE_REQUIRED, 'UUID of the fixity validation event.')
            ->addOption('digest_algorithm', null, InputOption::VALUE_REQUIRED, 'Algorithm used to generate the digest.')
            ->addOption('digest_value', null, InputOption::VALUE_REQUIRED, 'Value of the digest retrieved from the Fedora repository.')
            ->addOption('outcome', null, InputOption::VALUE_REQUIRED, 'Outcome of the event.');
        // phpcs:enable
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // phpcs:disable
        # Note: If this plugin is enabled in services.yaml, it executes but has no effect.

        # See PluginPostValidateMigrateFedora3AuditLogTest.php for code that implements the following logic.

        # For the current resource, retrieve the binary resource containing its Fedora 3.x AUDIT datastream.
        # Parse out the audit records (XPath $audit_xml->xpath('//audit:record').
        # For each record
            # Get its timestamp (XPath $record->xpath('./audit:date')[0]).
            # Get its justtfication (XPath $record->xpath('./audit:justification')[0]).
            # If the record's justification is 'PREMIS:eventType=fixity check', get the digest algorithm and event outcome from the justification.
            # Persist the record to Riprap's database.

            # Fixity events generated by Islandora's Checksum Checker module do not contain a digest value.
            # We will need to account for that when persisting these events.
        // phpcs:enable
    }
}
