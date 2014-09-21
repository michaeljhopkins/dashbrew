<?php

namespace Dashbrew;

use Dashbrew\Input\Input;
use Dashbrew\Input\InputInterface;
use Dashbrew\Output\Output;
use Dashbrew\Output\OutputInterface;

/**
 * Application Class.
 *
 * @package Dashbrew
 */
class Application extends \Symfony\Component\Console\Application {

    /**
     * Gets the name of the command based on input.
     *
     * @param InputInterface $input The input interface
     * @return string The command name
     */
    protected function getCommandName(InputInterface $input) {

        return 'provision';
    }

    /**
     * Gets the default commands that should always be available.
     *
     * @return array An array of default Command instances
     */
    protected function getDefaultCommands() {

        // Keep the core default commands to have the HelpCommand
        // which is used when using the --help option
        $defaultCommands = parent::getDefaultCommands();

        $defaultCommands[] = new Commands\ProvisionCommand();

        return $defaultCommands;
    }

    /**
     * Overridden so that the application doesn't expect the command
     * name to be the first argument.
     */
    public function getDefinition() {

        $inputDefinition = parent::getDefinition();

        // clear out the normal first argument, which is the command name
        $inputDefinition->setArguments();

        return $inputDefinition;
    }

    /**
     * Runs the application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     * @return int 0 if everything went fine, or an error code
     */
    public function run(InputInterface $input = null, OutputInterface $output = null) {

        if (null === $input) {
            $input = new Input();
        }

        if (null === $output) {
            $output = new Output();
        }

        return parent::run($input, $output);
    }

    /**
     * Renders a caught exception.
     *
     * @param \Exception      $e      An exception instance
     * @param OutputInterface $output An OutputInterface instance
     */
    public function renderException($e, $output) {
        do {
            $output->writeln(sprintf('[%s] %s (%s:%s)',
                get_class($e),
                $e->getMessage(),
                $e->getFile(),
                $e->getLine())
            );
        } while ($e = $e->getPrevious());
    }
}
