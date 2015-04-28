<?php

namespace HTTPPowerGrid;

class GameData extends \Game implements \PowerGrid\Interfaces\GameData {

  public function __construct() {
    parent::__construct();
  }

  /* GETTERS */

  /* MUTATORS */

  public function addPlayer($player) {
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
