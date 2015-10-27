<?php

namespace HTTPPowerGrid\Services;

class GameBankStarter extends \PowerGrid\Abstracts\GameBankStarter {
  public function createBank() {
    return new \Bank();
  }
}
