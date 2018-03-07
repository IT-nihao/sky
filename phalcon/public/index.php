<?php

use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Session\Adapter\Files as Session;
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
//define('UPLOAD_PATH', substr( __DIR__, 0, strrpos(__DIR__,DIRECTORY_SEPARATOR)).DIRECTORY_SEPARATOR ."public".DIRECTORY_SEPARATOR."files".DIRECTORY_SEPARATOR );

// Register an autoloader
$loader = new Loader();
$loader->registerDirs(
    array(
        APP_PATH . '/controllers/',
        APP_PATH . '/models/'
    )
)->register();

// Create a DI
$di = new FactoryDefault();

// // Setting up the view component
// $di['view'] = function() {
//     $view = new View();
//     $view->setViewsDir(APP_PATH . '/views/');
//     return $view;
// };
$di->set(
    "voltService",
    function ($view, $di) {
        $volt = new Volt($view, $di);
        $volt->setOptions(
            [
                "compiledPath"      => "../app/views/",
                // "compiledExtension" => ".compiled",
            ]
        );

        return $volt;
    }
);
$di->set(
    "view",
    function () {
        $view = new View();

        $view->setViewsDir(APP_PATH . '/views/');

        $view->registerEngines(
            [
                ".volt" => "voltService",
            ]
        );

        return $view;
    }
);
//Session
$di->setShared(
    "session",
    function () {
        $session = new Session();
        $session->start();

        return $session;
    }
);
// Setup a base URI so that all generated URIs include the "tutorial" folder
$di['url'] = function() {
    $url = new UrlProvider();
    $url->setBaseUri('/');
    return $url;
};


// Set the database service
$di['db'] = function() {
    return new DbAdapter(array(
        "host"     => "127.0.0.1",
        "username" => "root",
        "password" => "",
        "dbname"   => "test",
        "charset" => "utf8" 
    ));
};

// Handle the request
try {
    $application = new Application($di);
    echo $application->handle()->getContent();
} catch (Exception $e) {
     echo "Exception: ", $e->getMessage();
}
function dump($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}