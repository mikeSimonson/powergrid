<?php

namespace PowerGrid\Abstracts;

abstract class TurnOrderStarter {
  protected $game;
  protected $players;

  public function __construct(\PowerGrid\Interfaces\GameData $game, $players) {
    $this->game = $game;
    $this->players = $players;
  }

  /**
   * Create a randomly ordered set of turns, one for each player.
   */
  public function setup() {
    $turnOrders = range(1, count($this->players));
    shuffle($turnOrders);
    foreach ($this->players AS $player) {
      $turn = $this->createNewTurnOrderObj();
      $turn->setPlayer($player);
      $turn->setRank(array_pop($turnOrders));
      $turn->setRoundNumber($this->game->getRoundNumber());
      $turn->save();
    }
  }

  abstract protected function createNewTurnOrderObj();
}
