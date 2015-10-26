<?php

namespace HTTPPowerGrid;

class Game extends \PowerGrid\Abstracts\Game {

  /**
   *
   */
  protected function beginActionHook() {
  }

  /**
   * Commit any changes made by rules to the game.
   */
  protected function completeActionHook() {
    $this->game->save();
  }
}
