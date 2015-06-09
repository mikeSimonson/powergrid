<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/game', function() use ($app, $json_result) {
  // Create a game
  $app->post('/create', function() use ($app, $json_result) {
    $name = $app->request->params('name');
    $token = $app->request->params('token');
    $game = new \Game();

    $q = UserTokenQuery::create();
    $userToken = $q->findOneByTokenString($token);
    $user = $userToken->getTokenUser();

    if (is_null($name)) {
      $name = $user->getName() . "'s Game";
    }

    $game->setName($name);

    $game->setOwnerUser($user);

    $game->save();
    $json_result->setSuccess('Game created.');
    $json_result->addData('id', $game->getId());
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/create POST route

  $app->post('/:gameId/start', function($gameId) use ($app, $json_result) {
    $q = \GameQuery::create();
    $gameData = $q->findPK($gameId);
    $gameOwnerId = $gameData->getOwnerUser()->getId();

    $userToken = \UserTokenQuery::create()->findPK($app->request->params('token'));
    $callingUserId = $userToken->getTokenUser()->getId();

    try {
      $gameData->startGameForCallingUserId($callingUserId);
      $gameData->save();
      $json_result->setSuccess('Game started');
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
    
    $app->response->setBody($json_result->getJSON());

  }); // END /game/:gameId/start POST route

}); // END /game group
