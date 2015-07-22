<?php

namespace PowerGrid\Services;

class GamePlayerManager {
  protected $game;
  protected $player;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Interfaces\PlayerData $player) {
    $this->gameData = $game;
    $this->player = $player;
  }

  public function isPlayerInGame() {
    $playerInGame = FALSE;
    if ($this->gameData->getId() === $this->player->getGameId()) {
      $playerInGame = TRUE;
    }
    return $playerInGame;
  }

  public function joinPlayerToGame() {
    if ($this->isPlayerInGame()) {
      throw new \PowerGrid\Exceptions\PlayerAlreadyInGame();
    }
    $this->gameData->addPlayer($this->player);
  }
}
