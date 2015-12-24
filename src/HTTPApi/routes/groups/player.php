<?php

require_once('../bootstrap.php');
require_once(HTTPAPI_DIR . '/container.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$loadPropositionsMiddleware = function() {
  $propositionContainer = \PowerGrid\Propositions::inst();
  \HTTPPowerGrid\PropositionLoader::load($propositionContainer);
}

$app->group('/player', 'loadPropositionsMiddleware', function() use ($app, $json_result, $HTTPApiContainer) {

  $app->post('/startBid', function($playerId) use ($app, $json_result, $HTTPApiContainer) {

    $HTTPApiContainer['playerId'] = $playerId;
    $HTTPApiContainer['powerPlantCardId'] = $app->request->params('cardId');
    $HTTPApiContainer['userToken'] = $app->request->params('token');

    try {
      $userPlayerServices = $HTTPApiContainer['userPlayerServices'];
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
    }
    
    $bidAmount = $app->request->params('bid') ? $app->request->params('bid') : $powerPlant->getStartingAuctionPrice();

    $gameController = $userPlayerServices->getGameController();

    try {
      $gameController->startBid($player, $powerPlant, $bid);
      $json_result->setSuccess('Bidding started on plant');
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }

    $app->response->setBody($json_result->getJSON());
  });

  $app->post('/placeBid', function ($playerId) use ($app, $json_result, $HTTPApiContainer) {

    $bidAmount = $app->request->params('bidAmount');

    $HTTPApiContainer['powerPlantCardId'] = $app->request->params('cardId');
    $HTTPApiContainer['userToken'] = $app->request->params('token');
    $HTTPApiContainer['playerId'] = $playerId;

    try {
      $powerPlant = $HTTPApiContainer['powerPlant'];
      $userPlayerServices = $HTTPApiContainer['userPlayerServices'];
      $gameController->placeBid($player, $powerPlant, $bidAmount);
      $json_result->setSuccess('Bidding started on plant ' . $powerPlant->getId() . ' started at ' . '$' . $bidAmount);
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
    }

  });

});
