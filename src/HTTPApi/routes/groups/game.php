<?php

/**
 * All this route code is pretty shitty because each route could be widdled 
 * down to just a couple of lines if I ahd proper services for the HTTP layer. 
 * One day I will.
 */

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
  }); //END /game/list GET route
  
  $app->post('/create', function() use ($app, $json_result) {
    $token = $app->request->params('token');

    if (is_numeric($app->request->params('cardSet'))) {
      $cardSet = \CardSetQuery::create()
        ->findPK($app->request->params('cardSet'));
    }
    else {
      $cardSet = \CardSetQuery::create()
        ->filterByName('Originals')
        ->limit(1)
        ->findOne();
    }

    $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $name = $app->request->params('name');

    $userGameCreator = new \HTTPPowerGrid\Services\UserGameCreator($user);
    $userGameCreator->setGameName($name);
    $newGame = $userGameCreator->createGame();
    $newGame->setCardSet($cardSet);
    $newGame->save();
    $newGameId = $newGame->getId();

    $json_result->setSuccess('Game created.');
    $json_result->addData('id', $newGameId);
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  }); // END /game/create POST route

  $app->post('/:gameId/start', function($gameId) use ($app, $json_result) {
    $token = $app->request->params('token');
    $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $game = \GameQuery::create()->findPK($gameId);

    if (is_null($game)) {
      $json_result->addError('Game with id ' . intval($gameId) . ' does not exist.');
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());
      return;
    }

    $gameDeckSearcher = new \HTTPPowerGrid\Services\GameDeckSearcher($game);    
    $auctionStarter = new \HTTPPowerGrid\Services\AuctionStarter($game, $gameDeckSearcher);

    $cardShuffler = new \HTTPPowerGrid\Services\GameCardsShuffler($game);
    $deckStarter = new \HTTPPowerGrid\Services\GameDeckStarter($game, $game->getCardSet(), $cardShuffler);

    try {
      $gameStarter = new \HTTPPowerGrid\Services\GameStarter($game, $deckStarter, $auctionStarter);
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

  $app->post('/:gameId/join', function($gameId) use ($app, $json_result) {
    $token = $app->request->params('token');
    $user = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

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
