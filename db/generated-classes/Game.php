<?php

use Base\Game as BaseGame;

/**
 * Skeleton subclass for representing a row from the 'game' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Game extends BaseGame implements \PowerGrid\Interfaces\GameData
{

  /* GETTERS */

  public function isUserGameOwner($userId) {
    $isOwner = FALSE;
    if ($userId === $this->getOwnerId()) {
      $isOwner = TRUE;
    }

    return $isOwner;
  }

  public function isNumberOfJoinedPlayersValid() {
    $result = FALSE;
    
    $playerCount = $this->countPlayers();
    
    $minPlayers = $this->getMinimumNumberOfPlayers();
    $maxPlayers = $this->getMaximumNumberOfPlayers();

    if ($playerCount >= $minPlayers && $playerCount <= $maxPlayers) {
      $result = TRUE;
    }

    return $result;
  }

  public function haveMinimumNumberOfPlayersJoined() {
    $result = FALSE;
    
    $playerCount = $this->countPlayers();
    
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

  public function raiseAnyGameStartErrors($callingUserId) {
    if ($this->isUserGameOwner($callingUserId) === FALSE) {
      throw new \PowerGrid\Exceptions\Administrative\UserIsNotGameOwner();
    }

    if ($this->getHasStarted() === TRUE) {
      throw new \PowerGrid\Exceptions\Administrative\GameHasAlreadyStarted();
    }

    if ($this->isNumberOfJoinedPlayersValid() === FALSE) {
      throw new \PowerGrid\Exceptions\Administrative\NotEnoughPlayersHaveJoined();
    }
  }

  public function startGameForCallingUserId($callingUserId) {
    $this->raiseAnyGameStartErrors($callingUserId);
    $this->setHasStarted(TRUE);
  }

  /* MUTATORS */

  public function addPlayer(\Player $player) {
    if ($player->getGameId() !== $this->getId() && !is_null($player->getGameId())) {
      throw new \Exception("Player " . $player->getName() . " (" . $player->getId() . ")" . " is already in game " . $player->getGameId());
    }

    parent::addPlayer($player);
  }

  protected function advancePhase() {
    $nextPhaseNumber = $this->getPhaseNumber() + 1;

    $this->setPhaseNumber($nextPhaseNumber);
  }

  protected function advanceStep() {
    $nextStepNumber = $this->getStepNumber() + 1;

    $this->setStepNumber($nextStepNumber);
  }
}
