<?php

namespace HTTPPowerGrid\Services;

class GameStarter extends \PowerGrid\Services\GameStarter {
  protected $user;

  public function startGame(\User $user) {
    $this->user = $user;
    parent::startGame();
  }

  protected function raiseAnyGameStartExceptions() {
    parent::raiseAnyGameStartExceptions();
    
    if ($this->isUserGameOwner($this->user) === FALSE) {
      throw new \HTTPPowerGrid\Exceptions\Administrative\UserIsNotGameOwner();
    }
  }

  protected function setStartingGameDefaults() {
    parent::setStartingGameDefaults();
    $this->gameData->setOwnerUser($this->user);
  }
}
