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

  protected function instantiateGame() {
    $game = new \Game();
    return $game;
  }

  /**
   * @return int game id
   */
  public function createGame($gameName = NULL) {
    $this->gameName = $gameName;
    $this->game = $this->instantiateGame();
    $this->setGameMetaInfo();
    $this->saveGame();
  }

  public function getLastCreatedGameId() {
    return $this->game->getId();
  }

  protected function saveGame() {
    $this->game->save();
  }

  protected function setGameMetaInfo() {
    if (is_null($this->gameName)) {
      $this->gameName = $this->user->getName() . "'s Game";
    }
    $this->game->setName($this->gameName);
    $this->game->setOwnerUser($this->user);
  }
}
