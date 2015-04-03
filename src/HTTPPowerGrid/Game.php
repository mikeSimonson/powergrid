<?php

namespace \HTTPPowerGrid;

class Game extends \PowerGrid\Abstracts\Game {

  protected function startAction() {
  
  }

  protected function finishAction($rulesRunResult) {
    if ($rulesRunResult === TRUE) {
      $this->gameData->save();
    }
  }
}
