<?php

namespace PowerGrid\Services;

class PlayerServices {
  protected $player;

  public function __construct(\Player $player) {
    $this->player = $player;
  }

  public function setPlayerName($name) {

  }

  static public function createPlayer($name = NULL) {
    return new Player();
  }

}
