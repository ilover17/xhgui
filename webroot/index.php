<?php

ini_set('display_errors','on');
error_reporting(E_ALL);

require dirname(__DIR__) . '/src/bootstrap.php';

$di = new Xhgui_ServiceContainer();

$app = $di['app'];

require XHGUI_ROOT_DIR . '/src/routes.php';

$app->run();
