<?php

namespace PowerGrid\Abstracts;

abstract class GameDeckSearcher {

  protected $game;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }

  abstract public function getCheapestCards($quantity);
}
