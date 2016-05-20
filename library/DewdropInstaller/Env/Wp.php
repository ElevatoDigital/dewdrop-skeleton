<?php

namespace DewdropInstaller\Env;

class Wp extends EnvAbstract
{
    public function init()
    {
        $this
            ->setSelectionCharacter('w')
            ->setName('WordPress');
    }

    public function install()
    {
        $this->installer->copyFiles(
            [
                'wp-files/plugin-root-file.php' => getcwd() . '/' . basename(getcwd()) . '.php'
            ]
        );
    }
}

