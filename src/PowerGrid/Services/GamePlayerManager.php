<?php

namespace PowerGrid\Services;

class GamePlayerManager {
  protected $game;

  public function __construct(\Game $game) {
    $this->gameData = $game;
  }

  public function isPlayerInGame(\Player $player) {
    $playerInGame = FALSE;
    if ($this->gameData->getId() === $player->getGameId()) {
      $playerInGame = TRUE;
    }
    return $playerInGame;
  }

  public function joinPlayerToGame(\Player $game) {
    $this->addPlayerToGame($player);
  }
}
