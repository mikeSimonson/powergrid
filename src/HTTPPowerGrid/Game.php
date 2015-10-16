<?php

namespace HTTPPowerGrid;

class Game extends \PowerGrid\Abstracts\Game {

  /**
   *
   */
  protected function beginActionHook() {
  }

  /**
   * Commit any changes made by rules to the gameData.
   */
  protected function completeActionHook() {
    $this->gameData->save();
  }
}
