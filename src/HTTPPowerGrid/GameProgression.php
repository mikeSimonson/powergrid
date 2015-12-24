<?php

namespace HTTPPowerGrid;

use Propel\Runtime\ActiveQuery\Criteria;

class GameProgression extends \PowerGrid\Abstracts\GameProgression {

  protected function progressPhase() {
    $playersWhoHaveNotPlayed = \TurnOrderQuery::create()
      ->filterByGame($this->game)
      ->filterByRoundNumber($this->game->getRoundNumber())
      ->filterByPhaseNumber($this->game->getPhaseNumber())
      ->filterByHasActed(FALSE)
      ->find();

    if ($playersWhoHaveNotPlayed && count($playersWhoHaveNotPlayed) > 0) {
      $this->turnOrderUpdater->newOrder();
    }
  }

  protected function progressRound() {
    if ($this->game->getPhaseNumber() == static::NUMBER_PHASES_PER_ROUND) {
      $this->game->setRoundNumber($this->game->getRoundNumber() + 1);
      $this->game->save();
    }
  }

  protected function advanceTurnNumber() {
    parent::advanceTurnNumber();
    $this->game->save();
  }

  protected function progressStep() {
  }

}
