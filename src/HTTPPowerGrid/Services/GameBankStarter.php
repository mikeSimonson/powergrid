<?php

namespace HTTPPowerGrid\Services;

class GameBankStarter extends \PowerGrid\Abstracts\GameBankstarter {
  public function createBank() {
    return new \Bank();
  }
}
