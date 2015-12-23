<?php

namespace PowerGrid\Abstracts;

use Propel\Runtime\ActiveQuery\Criteria;

abstract class TurnOrderUpdater {
  protected $game;
  protected $players;

  public function __construct(\PowerGrid\Interfaces\GameData $game, Array $players) {
    $this->game = $game;
    $this->players = $players;
  }

  abstract public function newOrder();

}
