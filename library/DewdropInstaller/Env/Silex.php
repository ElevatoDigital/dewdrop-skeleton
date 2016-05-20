<?php

namespace DewdropInstaller\Env;

class Silex extends EnvAbstract
{
    public function init()
    {
        $this
            ->setSelectionCharacter('s')
            ->setName('Silex');
    }

    public function install()
    {
        $io = $this->installer->getIO();

        $io->write('<comment>Dewdrop Silex apps require a Postgres database.</comment>');
        $io->write('<comment>Please create a new Postgres database and enter the</comment>');
        $io->write('<comment>information needed to connect to it below.</comment>');
        $io->write('');

        $databaseName = $io->ask("<question>What is the database name?</question>\n");
        $username     = $io->ask("<question>What is the username?</question>\n");
        $password     = $io->askAndHideAnswer("<question>What is the password?</question>\n");
        $hostname     = $io->ask("<question>What is the database host?</question>\n");

        file_put_contents(
            '/tmp/dewdrop-config.tmp',
            str_replace(
                ['[db-username]', '[db-password]', '[db-host]', '[db-name]'],
                [$username, $password, $hostname, $databaseName],
                file_get_contents(__DIR__  . '/../silex-files/dewdrop-config.php')
            ),
            LOCK_EX
        );

        $this->installer->copyFiles(
            [
                'silex-files/Bootstrap.php'      => __DIR__ . '/../../App/Bootstrap.php',
                'silex-files/www-htaccess.txt'   => __DIR__ . '/../../../www/.htaccess',
                'silex-files/www-index.php'      => __DIR__ . '/../../../www/index.php',
                'silex-files/dewdrop-index.html' => __DIR__ . '/../../../www/dewdrop-index.html'
            ]
        );

        copy('/tmp/dewdrop-config.tmp', __DIR__ . '/../../../dewdrop-config.php');
    }
}

