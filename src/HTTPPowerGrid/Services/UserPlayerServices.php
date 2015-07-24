<?php

namespace HTTPPowerGrid\Services;

class UserPlayerServices {
  protected $user;
  protected $player;

  public function __construct(\User $user, \PowerGrid\Interfaces\PlayerData $player) {
    $this->user = $user;
    $this->player = $player;
  }

  public function getGameController() {
    if ($this->player->getUserId() !== $this->user->getId()) {
      throw new \HTTPPowerGrid\Exceptions\Administrative\UserCannotControlPlayer();
    }
    $gameData = $this->player->getGame();
    $ruleFactory = new \PowerGrid\Factories\RuleFactory();

    $gameController = new \HTTPPowerGrid\Game($gameData, $ruleFactory);

    return $gameController;
  }
}
