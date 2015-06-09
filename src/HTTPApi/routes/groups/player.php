<?php

require_once('../bootstrap.php');

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

$app->group('/player', function() use ($app, $json_result) {

  $app->post('/:playerId/startBid', function($playerId) use ($app, $json_result) {
    $player = PlayerQuery::create()
      ->findOneById($playerId);



    $token = $app->request->params('token');
    $user = UserTokenQuery::create()
      ->findOneByTokenString($token)
      ->getTokenUser();



  });

});
