<?php

use Dotenv\Dotenv;
use SONFin\Application;
use SONFin\Plugins\DbPlugin;
use SONFin\ServiceContainer;
use Zend\Diactoros\Response;
use SONFin\Plugins\AuthPlugin;
use SONFin\Plugins\ViewPlugin;
use SONFin\Plugins\RoutePlugin;
use Psr\Http\Message\RequestInterface;
use Illuminate\Support\Facades\Redirect;

require_once __DIR__ . '/../vendor/autoload.php';

if(file_exists(__DIR__ .'/../.env')) {
    $dotenv = new Dotenv(__DIR__ . '/../');
    $dotenv->overload();
}

require_once __DIR__ . '/../src/helpers.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

$app->get('/', function(RequestInterface $request) use($app) {
    $view  = $app->service('view.renderer');
    return $view->render('teste.html.twig', ['name' => 'Lucas Matheus']);
});

require_once __DIR__ . '/../src/controllers/charts.php';
require_once __DIR__ . '/../src/controllers/category-costs.php';
require_once __DIR__ . '/../src/controllers/bill-receives.php';
require_once __DIR__ . '/../src/controllers/bill-pays.php';
require_once __DIR__ . '/../src/controllers/statements.php';
require_once __DIR__ . '/../src/controllers/users.php';
require_once __DIR__ . '/../src/controllers/auth.php';



$app->start();