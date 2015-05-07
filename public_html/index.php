<?php

require_once('../bootstrap.php');

$json_result = new \HTTPApi\JSONResult();

$app = new \Slim\Slim();
$app->add(new \HTTPApi\Middleware\TokenAuthentication(($json_result)));

require_once('../src/HTTPApi/routes/groups/user.php');
require_once('../src/HTTPApi/routes/groups/game.php');

$app->run();
