<?php

require_once('../bootstrap.php');

$app = new \Slim\Slim();

$json_result = new \HTTPApi\JSONResult();

require_once('../src/HTTPApi/routes/groups/user.php');

$app->run();
