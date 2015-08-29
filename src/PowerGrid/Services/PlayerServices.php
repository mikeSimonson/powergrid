<?php

namespace PowerGrid\Services;

class PlayerServices {

  const DEFAULT_PLAYER_NAME_PREFIX = 'Player ';

  protected $player;
  protected $playerName;

  public function __construct(\PowerGrid\Interfaces\PlayerData $player) {
    $this->player = $player;
  }

  static public function createPlayer() {
    $newPlayer = new \Player();
    return $newPlayer;
  }

  public function setPlayerName($name) {
    $this->playerName = $name;
    $this->player->setName($name);
  }

  public function setPlayerDefaults(\PowerGrid\Interfaces\WalletData $wallet) {
    $this->player->setPlayerWallet($wallet);
    if (empty($this->playerName)) {
      $this->player->setName(static::DEFAULT_PLAYER_NAME_PREFIX . $this->player->getId());
    }
  }
}
