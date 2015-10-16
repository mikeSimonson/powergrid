<?php

//@TODO: This class is stupid. Why does it need all this state?

namespace HTTPPowerGrid\Services;

class UserGameCreator {

  protected $user;
  protected $game;
  protected $gameName;

  public function __construct($user) {
    $this->user = $user;
  }

  public function setGameName($name) {
    $this->gameName = $name;
  }

  public function createGame() {
    $this->game = new \Game();
    $this->setGameMetaInfo();
    return $this->game;
  }

  protected function setGameMetaInfo() {
    if (is_null($this->gameName)) {
      $this->gameName = $this->user->getName() . "'s Game";
    }
    $this->game->setName($this->gameName);
    $this->game->setOwnerUser($this->user);
  }
}
