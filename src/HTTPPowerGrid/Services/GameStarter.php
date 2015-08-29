<?php

namespace HTTPPowerGrid\Services;

class GameStarter extends \PowerGrid\Services\GameStarter implements \HTTPPowerGrid\Interfaces\Service {
  protected $user = NULL;

  public function startGame() {
    if (is_null($this->user)) {
      throw new \HTTPPowerGrid\Exceptions\Application\NoUserSet();
    }
    parent::startGame();
  }

  public function setStartingUser(\User $user) {
    $this->user = $user;
  }

  public function isUserGameOwner() {
    $userIsGameOwner = FALSE;
    if ($this->gameData->getOwnerId() === $this->user->getId()) {
      return TRUE;
    }
    return $userIsGameOwner;
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

  public function saveObjects() {
    $this->gameData->save();
  }
}
