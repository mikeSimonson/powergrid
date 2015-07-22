<?php

namespace PowerGrid\Services;

class GamePlayerManager extends \PowerGrid\Services\GamePlayerManager implements \HTTPPowerGrid\Interfaces\Service {

  protected function isPlayerInGame(\PowerGrid\Interfaces\PlayerData $player) {
    $playerInGame = FALSE;
    if ($this->gameData->getId() === $player->getGameId()) {
      $playerInGame = TRUE;
    }
    return $playerInGame;
  }

  protected function isUserInGameByPlayer() {
    $userInGame = array_reduce($this->gameData->getPlayers(), function ($previous, $gamePlayer) {
      $gamePlayerId = $gamePlayer->getId();
      return ($previous || ($gamePlayerId === $this->player->getId()));
    }, FALSE);

    return $userInGame;
  }

  public function joinPlayerToGame() {
    if ($this->isUserInGameByPlayer()) {
      throw new \HTTPPowerGrid\Exceptions\UserAlreadyInGame();
    }
    parent::joinPlayerToGame();
  }

  public function saveObjects() {
    $this->player->save();
    $this->game->save();
  }
}
