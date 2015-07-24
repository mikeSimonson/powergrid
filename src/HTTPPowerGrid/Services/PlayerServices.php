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

  static public function findPlayerById($playerId) {
    $player = \PlayerQuery::create()->findPK($playerId);
    if (is_null($player)) {
      throw new \HTTPPowerGrid\Exceptions\Administrative\PlayerDoesNotExist();
    }
    return $player;
  }

  public function saveObjects() {
    $this->player->save();
  }
}
