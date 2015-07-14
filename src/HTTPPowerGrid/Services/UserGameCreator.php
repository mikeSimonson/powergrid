<?php

namespace HTTPPowerGrid\Services;

class UserGameCreator {

  protected $user;

  public function __construct($user) {
    $this->user = $user;
  }

  static protected function instantiateGame() {
    $game = new \Game();
    return $game;
  }

  /**
   * @return int game id
   */
  public function createGameForUser($user, $name = NULL) {
    $this->name = $name;
    $this->game = static::instantiateGame();
    $this->setGameDetails();
    $this->saveGame();

    return $this->game->getId();
  }

  protected function saveGame() {
    $this->game->save();
  }

  protected function setGameDetails() {
    if (is_null($this->name)) {
      $this->name = $this->user->getName() . "'s Game";
    }

    $this->game->setName($this->name);

    $this->game->setOwnerUser($this->user);
  }
}
