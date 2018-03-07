<?php
/**
 * Created by PhpStorm.
 * User: 13611
 * Date: 2018/1/4
 * Time: 15:20
 */

use Phalcon\Mvc\View;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Events\Manager as EventsManager;

class Services extends \Base\Services
{
    protected function initRouter($options = array())
    {
        $config = $this->di['config'];

        $this->di['router'] = function () use ($config) {

            $router = new PhRouter(false);

            $router->notFound(
                array(
                    "controller" => "index",
                    "action" => "notFound",
                )
            );
            $router->removeExtraSlashes(true);

            foreach ($config['routes'] as $route => $items) {
                $router->add($route, $items->params->toArray())
                    ->setName($items->name);
            }

            return $router;
        };
    }
}