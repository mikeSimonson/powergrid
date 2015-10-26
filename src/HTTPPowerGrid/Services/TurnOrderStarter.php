<?php

namespace HTTPPowerGrid\Services;

class TurnOrderStarter extends \PowerGrid\Abstracts\TurnOrderStarter {
  protected function createNewTurnOrderObj() {
     $turn = new \TurnOrder();
     return $turn;
  }
}
