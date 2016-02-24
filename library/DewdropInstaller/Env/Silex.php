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
        $this->installer->getIO()->write('<error>Silex installer support is still under development.</error>');
    }
}

