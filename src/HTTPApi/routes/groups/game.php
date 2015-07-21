<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/game', function() use ($app, $json_result) {

  $app->post('/list', function() use ($app, $json_result) {
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

    $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $userGameCreator = new \HTTPPowerGrid\Services\UserGameCreator($user);
    $newGame = $userGameCreator->createGame();
    $newGame->save();
    $newGameId = $newGame->getId();

    $json_result->setSuccess('Game created.');
    $json_result->addData('id', $newGameId);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/create POST route

  $app->post('/:gameId/start', function($gameId) use ($app, $json_result) {
    $q = \GameQuery::create();
    $game = $q->findPK($gameId);
    
    $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $gameStarter = new \HTTPPowerGrid\Services\GameStarter($game);

    try {
      $gameStarter->startGame();
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

    $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);
    $userServices = new \HTTPPowerGrid\Services\UserServices($user);

    $game = \GameQuery::create()->findPK($gameId);
    $gamePlayerManager = new \PowerGrid\Services\GamePlayerManager($game);

    $userInGame = $userServices->isUserInGame($gamePlayerManager);
    
    if ($userInGame) {
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
      //$player->setName($playerUser->getName());
    }

    //$player->setPlayerUser($playerUser);

    $player->setPlayerWallet($playerWallet);

    $player->save();
    
    $json_result->setSuccess('Game joined.');
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/:gameId/join POST route
}); // END /game group
