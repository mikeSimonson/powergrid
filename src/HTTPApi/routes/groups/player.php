<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/player', function() use ($app, $json_result) {


  $app->post('/startBid', function($playerId) use ($app, $json_result) {
    try {
      $powerPlant = \HTTPPowerGrid\Services\CardServices::findCardById($app->request->params('cardId'));
      $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($app->request->params('token'));
      $player = \HTTPPowerGrid\Services\PlayerServices::findPlayerById($playerId);
      $userPlayerServices = new \HTTPPowerGrid\Services\UserPlayerServices($user, $player);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
    }

    $gameController = $userPlayerServices->getGameController();

    try {
      $gameController->startBid($player, $powerPlant);
      $json_result->setSuccess('Bidding started on plant');
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
    $app->response->setBody($json_result->getJSON());
  });

  $app->post('/placeBid', function ($playerId) use ($app, $json_result) {
    $bidAmount = $app->request->params('bidAmount');

    try {
      $gameController->startBid($player, $powerPlant, $bidAmount);
      $json_result->setSuccess('Bidding started on plant ' . $powerPlant->getId() . ' started at ' . '$' . $bidAmount);
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
  });
});
