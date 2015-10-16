<?php

namespace HTTPPowerGrid\Services;

class UserPlayerServices {
  protected $user;
  protected $player;

  public function __construct(\User $user, \PowerGrid\Interfaces\PlayerData $player) {
    $this->user = $user;
    $this->player = $player;
    if ($this->player->getUserId() !== $this->user->getId()) {
      throw new \HTTPPowerGrid\Exceptions\Administrative\UserCannotControlPlayer();
    }
  }

  public function getGameController() {
    $gameData = $this->player->getGame();
    $ruleFactory = new \PowerGrid\Factories\RuleFactory();
    $gameProgression = new \HTTPPowerGrid\GameProgression($gameData);

    $gameController = new \HTTPPowerGrid\Game($gameData, $gameProgression, $ruleFactory);

    return $gameController;
  }
}
