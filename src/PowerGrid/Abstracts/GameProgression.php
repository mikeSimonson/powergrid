<?php

namespace PowerGrid\Abstracts;

abstract class GameProgression {

  const NUMBER_PHASES_PER_ROUND = 5;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Abstracts\TurnOrderUpdater $turnOrderUpdater) {
    $this->game = $game;
    $this->turnOrderUpdater = $turnOrderUpdater;
  }

  public function progressGame() {
    $this->progressTurn();
    $this->progressPhase();
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

  abstract protected function progressRound();

  abstract protected function setNextPlayer();

  abstract protected function progressStep();

}
