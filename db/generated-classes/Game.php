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
