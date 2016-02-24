<?php

namespace DewdropInstaller;

use Composer\IO\IOInterface;
use Composer\Script\Event;
use DewdropInstaller\Env\EnvAbstract;
use DewdropInstaller\Env\Silex as SilexEnv;
use DewdropInstaller\Env\Wp as WpEnv;

class Installer
{
    /**
     * @var IOInterface
     */
    private $io;

    /**
     * @var array
     */
    private $environments = [];

    public function __construct(IOInterface $io)
    {
        $this->io = $io;

        $this->environments[] = new SilexEnv($this);
        $this->environments[] = new WpEnv($this);
    }

    /**
     * @param Event $event
     */
    public static function install(Event $event)
    {
        $installer = new Installer($event->getIO());
        $installer->run();
    }

    public function run()
    {
        $environmentOptions = [];

        /* @var $environment EnvAbstract */
        foreach ($this->environments as $environment) {
            $environmentOptions[$environment->getSelectionCharacter()] = $environment->getName();
        }

        $selected = $this->ask(
            'What type of Dewdrop project are you creating?',
            $environmentOptions
        );

        /* @var $environment EnvAbstract */
        foreach ($this->environments as $environment) {
            if ($environment->getSelectionCharacter() === $selected) {
                $environment->install();
            }
        }
    }

    public function getIO()
    {
        return $this->io;
    }

    public function ask($question, array $options)
    {
        $output = [];

        $output[] = sprintf('<question>%s</question>', $question);

        foreach ($options as $selection => $title) {
            $output[] = sprintf('[<comment>%s</comment>] %s', $selection, $title);
        }

        while (1) {
            $answer = $this->io->ask(implode(PHP_EOL, $output) . PHP_EOL);

            if (!array_key_exists($answer, $options)) {
                $this->io->write('<error>Invalid option selected.</error>');
            } else {
                return $answer;
            }
        }
    }

    public function copyFiles(array $files)
    {
        foreach ($files as $source => $destination) {
            copy(
                __DIR__ . '/' . $source,
                $destination
            );
        }

        return $this;
    }
}

