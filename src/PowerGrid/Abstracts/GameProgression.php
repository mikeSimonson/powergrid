<?php

namespace PowerGrid\Abstracts;

class GameProgression {

  public function __construct(\PowerGrid\Interfaces\GameData $gameData) {
    $this->gameData = $gameData;
  }

  public function progressGame() {
    $this->progressTurn();
    $this->progressRound();
    $this->progressStep();
  }

  protected function progressTurn() {
    $this->advanceTurnNumber();
    $this->setNextPlayer();
  }

  protected function advanceTurnNumber() {
    $currentTurnNumber = $this->gameData->getTurnNumber();
    $this->gameData->setTurnNumber($currentTurnNumber + 1);
  }

  protected function progressRound() {
    
  }

  abstract protected function setNextPlayer();
}
