<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/game', function() use ($app, $json_result) {

  $app->get('/list', function() use ($app, $json_result) {
    $games = \GameQuery::create()->find();
    $gameLister = new \PowerGrid\Services\GameLister($games);
    $gameList = $gameLister->createList();
    $json_result->setSuccess('Games list in data field.');
    $json_result->addData('gamesList', $gameList);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  });
  
  $app->post('/create', function() use ($app, $json_result) {
    $name = $app->request->params('name');
    $token = $app->request->params('token');

    $q = UserTokenQuery::create();
    $userToken = $q->findOneByTokenString($token);
    $user = $userToken->getTokenUser();

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

      // @TODO: This is terrible and does not belong here.
      $players = $gameData->getPlayers();
      $playerCount = $gameData->countPlayers();
      if ($playerCount == 2) {
        $gameData->setCardLimit(4);
      }
      else {
        $gameData->setCardLimit(3);
      }

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

    $player->save();
    
    $json_result->setSuccess('Game joined.');
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/:gameId/join POST route
}); // END /game group
