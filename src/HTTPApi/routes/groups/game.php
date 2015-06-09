<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/game', function() use ($app, $json_result) {

  $app->post('/list', function() use ($app, $json_result) {
    $games = \GameQuery::create()->find();
    $gamesList = array();
    foreach ($games AS $game) {
      $gameInfo = array();
      $gameInfo['name'] = $game->getName();
      $gameInfo['hasStarted'] = $game->getHasStarted();
      $gamesList[$game->getId()] = $gameInfo;
    }

    $json_result->setSuccess('Games list in data field.');
    $json_result->addData('gamesList', $gamesList);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  });
  
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

      // @TODO: This is terrible and does not belong here.
      $players = $gameData->getPlayers();
      $playerCount = $gameData->countPlayers();
      foreach ($players as $player) {
        if ($playerCount == 2) {
          $player->setCardLimit(4);
        }
        else {
          $player->setCardLimit(3);
        }

        $player->save();
      }

      $json_result->setSuccess('Game started');
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
    
    $app->response->setBody($json_result->getJSON());
  }); // END /game/:gameId/start POST route

  $app->post('/:gameId/join', function($gameId) use ($app, $json_result) {
    $token = $app->request->params('token');
    $playerUser = UserTokenQuery::create()
      ->findOneByTokenString($token)
      ->getTokenUser();

    $player = \PlayerQuery::create()
      ->filterByPlayerUser($playerUser)
      ->filterByGameId($gameId)
      ->findOne();

    if ($player !== NULL) {
      $json_result->addError('You are already in this game.');
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
      return;
    }

    $player = new \Player();
    $playerWallet = new \Wallet();
    //@TODO: Sensible way to set player wallet starting amount. Don't do it in 
    //the db.

    $player->setGameId($gameId);

    $passedPlayerName = $app->request->params('name');
    if (!empty($passedPlayerName)) {
      $player->setName($passedPlayerName);
    }
    else {
      $player->setName($playerUser->getName());
    }

    $player->setPlayerUser($playerUser);

    $player->setPlayerWallet($playerWallet);
    
    $json_result->setSuccess('Game joined.');
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/:gameId/join POST route
}); // END /game group
