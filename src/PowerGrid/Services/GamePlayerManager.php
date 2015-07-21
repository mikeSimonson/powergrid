<?php

namespace PowerGrid\Services;

class GamePlayerManager {
  protected $game;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->gameData = $game;
  }

  public function isPlayerInGame(\PowerGrid\Interfaces\PlayerData $player) {
    $playerInGame = FALSE;
    if ($this->gameData->getId() === $player->getGameId()) {
      $playerInGame = TRUE;
    }
    return $playerInGame;
  }

  public function joinPlayerToGame() {
    $this->addPlayerToGame($this->player);
  }
}
