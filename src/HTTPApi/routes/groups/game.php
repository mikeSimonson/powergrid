<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/game', function() use ($app, $json_result) {
  // Create a game
  $app->post('/create', function() use ($app, $json_result) {
    $name = $app->request->params('name');
    $token = $app->request->params('token');
    $game = new \HTTPPowerGrid\GameData();

    // Default to the user's name if a game name is not passed along
    if (is_null($name)) {
      $q = UserTokenQuery::create();
      $userToken = $q->findOneByTokenString($token);
      $user = $userToken->getTokenUser();
      $name = $user->getName() . "'s Game";
    }
    $game->setName($name);

    $game->save();
    $json_result->setSuccess('Game created.');
    $json_result->addData('id', $game->getId());
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/ POST route

  $app->post('/:gameId/start', function($gameId) use ($app, $json_result) {
    $q = \GameQuery::create();
    $gameData = $q->findPK($gameId);
    $gameOwnerId = $gameData->getOwnerUser()->getId();

    $userToken = \UserTokenQuery::create()->findPK($app->request->params('token'));
    $callingUserId = $userToken->getTokenUser()->getId();

    if ($gameOwnerId !== $callingUserId) {
      $json_result->addError('Only the game owner can start a game.');
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
      return;
    }

    if ($gameData->getHasStarted() === TRUE) {
      $json_result->addError('Game has already started.');
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
      return;
    }

    $gameData->setHasStarted(TRUE);
    $gameData->save();
  }); // END /game/:gameId/start POST route

}); // END /game group
