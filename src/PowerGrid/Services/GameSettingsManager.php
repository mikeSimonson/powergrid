<?php

namespace PowerGrid\Services;

class GameSettingsManager {
  protected $gameData;

  public function __construct(\Game $gameData) {
    $this->gameData = $gameData;
  }

  public function intializeGameDefaults() {
    
  }
}
