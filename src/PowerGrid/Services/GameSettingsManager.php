<?php

namespace PowerGrid\Services;

class GameSettingsManager {
  protected $game;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }

  public function intializeGameDefaults() {
    
  }
}
