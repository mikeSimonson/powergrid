<?php

namespace HTTPPowerGrid\Services;

class PlayerServices extends \PowerGrid\Services\PlayerServices {

  protected $user;

  static public function createPlayer(\User $user) {
    $this->user = $user;
    $newPlayer = parent::createPlayer();
    $newPlayer->setPlayerUser($user);
    return $newPlayer;
  }

  public function setPlayerName($name) {
    $this->playerName = $name;
    $this->player->setName($name);
  }

  public function setPlayerDefaults(\PowerGrid\Interfaces\WalletData $wallet) {
    if (empty($this->playerName)) {
      $this->player->setName($this->user->getName());
    }
    parent::setPlayerDefaults($wallet);
  }
}
