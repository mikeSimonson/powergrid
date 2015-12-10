<?php

namespace PowerGrid\Abstracts;

abstract class GameProgression {

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
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
    $currentTurnNumber = $this->game->getTurnNumber();
    $this->game->setTurnNumber($currentTurnNumber + 1);
  }

  protected function progressRound() {
    
  }

  abstract protected function setNextPlayer();
}
