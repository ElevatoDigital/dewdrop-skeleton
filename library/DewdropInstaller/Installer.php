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
     * @param Event $event
     */
    public static function install(Event $event)
    {
        echo 'Hello, WP!' . PHP_EOL;
    }
}
