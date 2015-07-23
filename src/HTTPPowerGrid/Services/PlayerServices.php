<?php

namespace HTTPPowerGrid\Services;

class PlayerServices extends \PowerGrid\Services\PlayerServices implements \HTTPPowerGrid\Interfaces\Service {

  protected $user;

  public function setPlayerUser(\User $user) {
    $this->user = $user;
    $this->player->setPlayerUser($user);
  }

  public function setPlayerDefaults(\PowerGrid\Interfaces\WalletData $wallet) {
    if (empty($this->playerName)) {
      $this->playerName = $this->user->getName();
      $this->player->setName($this->playerName);
    }
    parent::setPlayerDefaults($wallet);
  }

  public function saveObjects() {
    $this->player->save();
  }
}
