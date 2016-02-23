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
     * @var IOInterface
     */
    private $io;

    public function __construct(IOInterface $io)
    {
        $this->io = $io;

        echo get_class($this->io) . PHP_EOL;
        exit;
    }

    /**
     * @param Event $event
     */
    public static function install(Event $event)
    {
        $installer = new Installer($event->getIO());
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

