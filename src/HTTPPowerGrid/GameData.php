<?php

namespace HTTPPowerGrid;

class GameData extends \Game implements \PowerGrid\Interfaces\GameData {

  public function __construct() {
    parent::__construct();

    $this->setTurnNumber(0);
    $this->setStepNumber(0);
  }

  /* GETTERS */

  /* MUTATORS */

  public function addPlayer($player) {
    if ($player->getGameId() !== $this->getId() && !is_null($player->getGameId())) {
      throw new \Exception("Player " . $player->getName() . " (" . $player->getId() . ")" . " is already in game " . $player->getGameId());
    }
    $player->setCurrentGame($this);
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
