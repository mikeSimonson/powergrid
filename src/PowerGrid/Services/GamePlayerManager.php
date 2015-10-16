<?php

namespace PowerGrid\Services;

class GamePlayerManager {
  const MAX_PLAYERS_PER_GAME = 6;
  protected $gameData;
  protected $player;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Interfaces\PlayerData $player) {
    $this->gameData = $game;
    $this->player = $player;
  }

  protected function isPlayerInGame() {
    $playerInGame = FALSE;
    if ($this->gameData->getId() === $this->player->getGameId()) {
      $playerInGame = TRUE;
    }
    return $playerInGame;
  }

  public function joinPlayerToGame() {
    if ($this->isPlayerInGame()) {
      throw new \PowerGrid\Exceptions\Administrative\PlayerAlreadyInGame();
    }
    else if (count($this->gameData->getPlayers()) >= static::MAX_PLAYERS_PER_GAME) {
      throw new \PowerGrid\Exceptions\Administrative\MaxPlayersAlreadyInGame(static::MAX_PLAYERS_PER_GAME);
    }
    $this->gameData->addPlayer($this->player);
  }
}
