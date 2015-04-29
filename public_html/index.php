<?php

require_once('../bootstrap.php');

$app = new \Slim\Slim();

require_once('../src/HTTPApi/user.php');

$app->run();

?>
