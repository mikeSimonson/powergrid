<?php

namespace PowerGrid\Services;

class GameCreator {
  public function createNewGame() {
    $game = new \Game();
    return $game;
  }
}
