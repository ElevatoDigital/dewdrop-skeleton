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

    public function install($title)
    {
        $this->installer->copyFiles(
            [
                'wp-files/plugin-root-file.php' => getcwd() . '/' . basename(getcwd()) . '.php'
            ]
        );

        $file_contents = file_get_contents($getcwd() . '/' . basename(getcwd()) . '.php');
        $file_contents = str_replace("Dewdrop Skeleton Project", $title, $file_contents);
        file_put_contents($getcwd() . '/' . basename(getcwd()) . '.php', $file_contents);
    }
}

