<?php

namespace PowerGrid\Services;

class GameStarter {

  const STARTING_CARD_LIMIT_2_PLAYERS = 4;
  const STARTING_CARD_LIMIT_MORE_THAN_2_PLAYERS = 3;

  protected $gameData;
  protected $cardShuffler;
  protected $auctionServices;

  public function __construct(\PowerGrid\Interfaces\GameData $gameData, \PowerGrid\Services\CardShuffler $cardShuffler, \PowerGrid\Services\AuctionServices $auctionServices) {
    $this->gameData = $gameData;
    $this->cardShuffler = $cardShuffler;
    $this->auctionServices = $auctionServices;
  }

  public function startGame() {
    $this->raiseAnyGameStartExceptions();
    $this->setStartingGameDefaults();
    $this->gameData->save();
  }

  protected function raiseAnyGameStartExceptions() {
    if ($this->gameData->getHasStarted() === TRUE) {
      throw new \PowerGrid\Exceptions\Administrative\GameHasAlreadyStarted();
    }

    if ($this->isNumberOfJoinedPlayersValid() === FALSE) {
      throw new \PowerGrid\Exceptions\Administrative\NotEnoughPlayersHaveJoined();
    }
  }

  protected function isNumberOfJoinedPlayersValid() {
    $result = FALSE;
    
    $playerCount = $this->gameData->countPlayers();
    
    $minPlayers = $this->getMinimumNumberOfPlayers();
    $maxPlayers = $this->getMaximumNumberOfPlayers();

    if ($playerCount >= $minPlayers && $playerCount <= $maxPlayers) {
      $result = TRUE;
    }

    return $result;
  }

  protected function haveMinimumNumberOfPlayersJoined() {
    $result = FALSE;
    
    $playerCount = $this->gameData->countPlayers();
    
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

  protected function setStartingGameDefaults() {
    $this->setCardLimit();
    $this->auctionServices->setupStartingAuction();
    $this->cardShuffler->shuffle();
    $this->cardShuffler->removeExtraCards();
    $this->setGameHasStarted();
  }

  protected function setGameHasStarted() {
    $this->gameData->setHasStarted(TRUE);
  }

  protected function setCardLimit() {
    if ($this->gameData->countPlayers() == 2) {
      $this->gameData->setCardLimit(static::STARTING_CARD_LIMIT_2_PLAYERS);
    }
    else {
      $this->gameData->setCardLimit(static::STARTING_CARD_LIMIT_MORE_THAN_2_PLAYERS);
    }
  }
}
