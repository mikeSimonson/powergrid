<?php

namespace PowerGrid\Abstracts;

abstract class GameBankStarter {

  const STARTING_BALANCE = 250;

  protected $game;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }

  public function setup() {
    $bank = $this->createBank();
    $bank->setBalance(static::STARTING_BALANCE);
    $bank->save();
    $this->game->setBank($bank);
  }

  abstract public function createBank();
}
