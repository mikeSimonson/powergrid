<?php

namespace PowerGrid\Services;

class GameStarter {

  const STARTING_CARD_LIMIT_2_PLAYERS = 4;
  const STARTING_CARD_LIMIT_MORE_THAN_2_PLAYERS = 3;

  protected $game;
  protected $gameDeckStarter;
  protected $auctionStarter;
  protected $bankStarter;
  protected $turnOrderStarter;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Abstracts\GameDeckStarter $gameDeckStarter, \PowerGrid\Abstracts\AuctionStarter $auctionStarter, \PowerGrid\Abstracts\GameBankStarter $bankStarter, \PowerGrid\Abstracts\TurnOrderStarter $turnOrderStarter) {
    $this->game = $game;
    $this->gameDeckStarter = $gameDeckStarter;
    $this->auctionStarter = $auctionStarter;
    $this->bankStarter = $bankStarter;
    $this->turnOrderStarter = $turnOrderStarter;
  }

  public function startGame() {
    $this->raiseAnyGameStartExceptions();
    $this->setStartingGameDefaults();
    $this->game->save();
  }

  protected function raiseAnyGameStartExceptions() {
    if ($this->game->getHasStarted() === TRUE) {
      throw new \PowerGrid\Exceptions\Administrative\GameHasAlreadyStarted();
    }

    if ($this->isNumberOfJoinedPlayersValid() === FALSE) {
      throw new \PowerGrid\Exceptions\Administrative\NotEnoughPlayersHaveJoined();
    }
  }

  protected function isNumberOfJoinedPlayersValid() {
    $result = FALSE;
    
    $playerCount = $this->game->countPlayers();
    
    $minPlayers = $this->getMinimumNumberOfPlayers();
    $maxPlayers = $this->getMaximumNumberOfPlayers();

    if ($playerCount >= $minPlayers && $playerCount <= $maxPlayers) {
      $result = TRUE;
    }

    return $result;
  }

  protected function haveMinimumNumberOfPlayersJoined() {
    $result = FALSE;
    
    $playerCount = $this->game->countPlayers();
    
    $minPlayers = $this->getMinimumNumberOfPlayers();

    if ($playerCount >= $minPlayers) {
      $result = TRUE;
    }

    return $result;
  }

  protected function getMinimumNumberOfPlayers() {
    return \PowerGrid\Interfaces\GameData::MIN_PLAYERS;
  }

  protected function getMaximumNumberOfPlayers() {
    return \PowerGrid\Interfaces\GameData::MAX_PLAYERS;
  }

  protected function setGameHasStarted() {
    $this->game->setHasStarted(TRUE);
  }

  protected function setCardLimit() {
    if ($this->game->countPlayers() == 2) {
      $this->game->setCardLimit(static::STARTING_CARD_LIMIT_2_PLAYERS);
    }
    else {
      $this->game->setCardLimit(static::STARTING_CARD_LIMIT_MORE_THAN_2_PLAYERS);
    }
  }

  protected function setStartingGameDefaults() {
    $this->setCardLimit();
    $this->bankStarter->setup();
    $this->turnOrderStarter->setup();
    $this->gameDeckStarter->setup();
    $this->auctionStarter->setup();
    $this->setGameHasStarted();
  }
}
