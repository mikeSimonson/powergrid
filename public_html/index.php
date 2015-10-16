<?php

require_once("../bootstrap.php");

$json_result = new \HTTPApi\JSONResult();

$app = new \Slim\Slim();
$app->add(new \HTTPApi\Middleware\AdminGroupAuthorization($json_result));
$app->add(new \HTTPApi\Middleware\TokenAuthentication($json_result));

$apiSrcPath = "../src/HTTPApi/routes/groups";

require_once("{$apiSrcPath}/user.php");
require_once("{$apiSrcPath}/game.php");
require_once("{$apiSrcPath}/player.php");
require_once("{$apiSrcPath}/admin.php");

$app->run();
