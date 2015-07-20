<?php

namespace HTTPPowerGrid\Services;

class UserServices {

  protected $user;

  public function __construct(\User $user) {
    $this->user = $user;
  }

  static public function getUserByToken($tokenString) {
    $q = \UserTokenQuery::create();
    $userToken = $q->findOneByTokenString($tokenString);
    $user = $userToken->getTokenUser();
    return $user;
  }

  public function isUserInGame(\PowerGrid\Services\GamePlayerManager $gamePlayerManager) {
    $userInGame = FALSE;

    foreach ($this->user->getPlayers() AS $player) {
      if ($gamePlayerManager->isPlayerInGame($player)) {
        $userInGame = TRUE;
      }
    }

    return $userInGame;
  }
}
