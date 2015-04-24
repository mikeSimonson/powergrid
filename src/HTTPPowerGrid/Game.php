<?php

namespace HTTPPowerGrid;

class Game extends \PowerGrid\Abstracts\Game {

  /**
   *
   */
  protected function startAction() {
  }

  /**
   * Commit any changes made by rules to the gameData.
   */
  protected function finishAction() {
    $this->gameData->save();
  }
}
