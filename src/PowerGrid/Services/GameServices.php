<?php

namespace PowerGrid\Services;

class GameServices {
  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }
}
