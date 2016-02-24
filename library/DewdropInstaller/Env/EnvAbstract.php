<?php

namespace DewdropInstaller\Env;

use DewdropInstaller\Exception;
use DewdropInstaller\Installer;

abstract class EnvAbstract
{
    /**
     * @var Installer
     */
    protected $installer;

    /**
     * @var string
     */
    private $selectionCharacter;

    /**
     * @var string
     */
    private $name;

    public function __construct(Installer $installer)
    {
        $this->installer = $installer;

        $this->init();

        if (!$this->selectionCharacter) {
            throw new Exception('Selection character must be set by all environments.');
        }

        if (!$this->name) {
            throw new Exception('Name must be set by all environments.');
        }
    }

    abstract public function init();

    abstract public function install();

    public function setSelectionCharacter($selectionCharacter)
    {
        if (!is_string($selectionCharacter) || 1 !== strlen($selectionCharacter)) {
            throw new Exception('Selection character must be a single character.');
        }

        $this->selectionCharacter = strtolower($selectionCharacter);

        return $this;
    }

    public function getSelectionCharacter()
    {
        return $this->selectionCharacter;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}

