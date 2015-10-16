<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/game', function() use ($app, $json_result) {

  $token = $app->request->params('token');
  $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

  $app->get('/list', function() use ($app, $json_result) {
    $games = \GameQuery::create()->find();
    $gameLister = new \PowerGrid\Services\GameLister($games);
    $gameList = $gameLister->createList();
    $json_result->setSuccess('Games list in data field.');
    $json_result->addData('gamesList', $gameList);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); //END /game/list GET route
  
  $app->post('/create', function() use ($app, $json_result, $user) {
    $name = $app->request->params('name');

    $userGameCreator = new \HTTPPowerGrid\Services\UserGameCreator($user);
    $userGameCreator->setGameName($name);
    $newGame = $userGameCreator->createGame();
    $newGame->save();
    $newGameId = $newGame->getId();

    $json_result->setSuccess('Game created.');
    $json_result->addData('id', $newGameId);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/create POST route

  $app->post('/:gameId/start', function($gameId) use ($app, $json_result, $user) {
    $game = \GameQuery::create()->findPK($gameId);

    if (is_null($game)) {
      $json_result->addError('Game with id ' . intval($gameId) . ' does not exist.');
      return;
    }

    try {
      $gameStarter = new \HTTPPowerGrid\Services\GameStarter($game);
      $gameStarter->setStartingUser($user);
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

  $app->post('/:gameId/join', function($gameId) use ($app, $json_result, $user) {
    $playerName = $app->request->params('name');

    $userServices = new \HTTPPowerGrid\Services\UserServices($user);

    $player = \HTTPPowerGrid\Services\PlayerServices::createPlayer();
    $playerServices = new \HTTPPowerGrid\Services\PlayerServices($player);
    $wallet = \PowerGrid\Services\WalletServices::createWallet();
    $playerServices->setPlayerUser($user);
    if (!empty($playerName)) {
      $playerServices->setPlayerName($playerName);
    }
    $playerServices->setPlayerDefaults($wallet);

    $game = \HTTPPowerGrid\Services\GameServices::findGameById($gameId);
    $gamePlayerManager = new \HTTPPowerGrid\Services\GamePlayerManager($game, $player);

    try {
      $gamePlayerManager->joinPlayerToGame();
      $gamePlayerManager->saveObjects();
      $playerServices->saveObjects();

      $json_result->setSuccess('Game joined.');
      $json_result->addData('playerId', $player->getId());
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
    
    $app->response->setBody($json_result->getJSON());
  }); // END /game/:gameId/join POST route

}); // END /game group
