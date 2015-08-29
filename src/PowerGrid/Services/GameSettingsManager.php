<?php

namespace PowerGrid\Services;

class GameSettingsManager {
  protected $gameData;

  public function __construct(\PowerGrid\Interfaces\GameData $gameData) {
    $this->gameData = $gameData;
  }

  public function intializeGameDefaults() {
    
  }
}
