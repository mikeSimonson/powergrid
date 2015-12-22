<?php

namespace PowerGrid\Abstracts;

abstract class AuctionStatus {

  protected $game;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }

  abstract public function isComplete();

}
