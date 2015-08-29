<?php

namespace HTTPPowerGrid\Services;

class GamePlayerManager extends \PowerGrid\Services\GamePlayerManager implements \HTTPPowerGrid\Interfaces\Service {

  protected function isUserInGameByPlayer() {
    $userInGame = FALSE;
    $playerUserId = $this->player->getUserId();
    foreach ($this->gameData->getPlayers() as $gamePlayer) {
      $gamePlayerUserId = $gamePlayer->getUserId();
      if ($gamePlayerUserId === $playerUserId) {
        $userInGame = TRUE;
        break;
      }
    }
    return $userInGame;
  }

  public function joinPlayerToGame() {
    if ($this->isUserInGameByPlayer()) {
      throw new \HTTPPowerGrid\Exceptions\Administrative\UserAlreadyInGame();
    }
    parent::joinPlayerToGame();
  }

  public function saveObjects() {
    $this->player->save();
    $this->gameData->save();
  }
}
