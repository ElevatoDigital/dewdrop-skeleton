<?php

namespace App;

use Dewdrop\Admin\Env\Silex as SilexAdmin;
use Dewdrop\Bootstrap\PimpleProviderInterface;
use Dewdrop\Config;
use Dewdrop\Db\Adapter as DbAdapter;
use Dewdrop\Db\Driver\Pdo\Pgsql;
use Dewdrop\Exception;
use Dewdrop\Paths;
use Dewdrop\View\View;
use Monolog\Logger;
use PDO;
use Silex\Application as Silex;
use Silex\Provider\MonologServiceProvider;

class Bootstrap implements PimpleProviderInterface
{
    /**
     * @var Silex
     */
    private $silex;

    public function __construct()
    {
        $this->silex = new Silex();
    }

    /**
     * @return Silex
     */
    public function getPimple()
    {
        $this->addPimpleResources();
        return $this->silex;
    }

    public function addPimpleResources()
    {
        $this->silex['paths'] = $this->silex->share(
            function () {
                return new Paths();
            }
        );

        $this->silex['application-env'] = getenv('APPLICATION_ENV');

        $this->silex['debug'] = ('development' === $this->silex['application-env'] ? true : false);

        $this->silex->register(
            new MonologServiceProvider(),
            [
                'monolog.logfile' => $this->silex['paths']->getAppRoot() . '/logs/' . $this->silex['application-env'] . '.log',
                'monolog.level'   => Logger::WARNING
            ]
        );

        $this->silex['view'] = function () {
            $view = new View();

            $view
                ->registerHelper('inputtext', '\Dewdrop\View\Helper\BootstrapInputText')
                ->registerHelper('select', '\Dewdrop\View\Helper\BootstrapSelect')
                ->registerHelper('textarea', '\Dewdrop\View\Helper\BootstrapTextarea');

            return $view;
        };

        $this->silex['admin'] = $this->silex->share(
            function () {
                $admin = new SilexAdmin($this->silex);
                return $admin;
            }
        );

        $this->silex['config'] = $this->silex->share(
            function () {
                $config = new Config();
                if (!$config->has($this->silex['application-env'])) {
                    return $config->get('development');
                }
                return $config->get($this->silex['application-env']);
            }
        );

        $this->silex['db'] = $this->silex->share(
            function () {
                $config = $this->silex['config'];

                $pdo = new PDO(
                    'pgsql:dbname=' . $config['db']['name'] . ';host=' . $config['db']['host'],
                    $config['db']['username'],
                    $config['db']['password']
                );

                $adapter = new DbAdapter();
                new Pgsql($adapter, $pdo);

                return $adapter;
            }
        );
    }
}
