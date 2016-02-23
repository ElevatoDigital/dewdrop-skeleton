<?php

namespace DewdropInstaller;

use Composer\Composer;
use Composer\Factory;
use Composer\IO\IOInterface;
use Composer\Json\JsonFile;
use Composer\Package\AliasPackage;
use Composer\Package\Link;
use Composer\Package\Version\VersionParser;
use Composer\Script\Event;
use Composer\Package\BasePackage;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Installer
{
    /**
     * @var Event
     */
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->io    = $event->getIO();

        echo get_class($this->io) . PHP_EOL;
        exit;
    }

    /**
     * @param Event $event
     */
    public static function install(Event $event)
    {
        $installer = new Installer($event);
        $installer->run();
    }

    private function copyFiles(array $files)
    {
        foreach ($this->files as $source => $destination) {
            copy(
                __DIR__ . '/' . $source,
                $destination
            );
        }

        return $this;
    }

    private function installSilex()
    {

    }

    private function installWordPress()
    {
        $this->copyFiles(
            [
                'wp-files/plugin-root-file.php' => getcwd() . '/' . basename(getcwd()) . '.php'
            ]
        );
    }
}

