<?php

namespace HTTPPowerGrid\Services;

class TurnOrderStarter extends \PowerGrid\Abstracts\TurnOrderStarter {
  static public function createNewTurnOrderObj() {
     $turn = new \TurnOrder();
     return $turn;
  }
}
