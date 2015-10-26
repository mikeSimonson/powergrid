<?php

namespace PowerGrid\Services;

class GamePlayerManager {
  const MAX_PLAYERS_PER_GAME = 6;
  protected $game;
  protected $player;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Interfaces\PlayerData $player) {
    $this->game = $game;
    $this->player = $player;
  }

  protected function isPlayerInGame() {
    $playerInGame = FALSE;
    if ($this->game->getId() === $this->player->getGameId()) {
      $playerInGame = TRUE;
    }
    return $playerInGame;
  }

  public function joinPlayerToGame() {
    if ($this->isPlayerInGame()) {
      throw new \PowerGrid\Exceptions\Administrative\PlayerAlreadyInGame();
    }
    else if (count($this->game->getPlayers()) >= static::MAX_PLAYERS_PER_GAME) {
      throw new \PowerGrid\Exceptions\Administrative\MaxPlayersAlreadyInGame(static::MAX_PLAYERS_PER_GAME);
    }
    $this->game->addPlayer($this->player);
  }
}
