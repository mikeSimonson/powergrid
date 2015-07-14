<?php

namespace PowerGrid\Services;

class GameLister {

  public function __construct($games) {
    foreach ($games AS $game) {
      if (!($game instanceof \PowerGrid\Interfaces\GameData)) {
        throw new \PowerGrid\Exceptions\Application\UnexpectedObjectType('\PowerGrid\Interfaces\GameData', $game);
      }
    }
    $this->gamesData = $games;
  }

  public function createList() {
    $gamesList = array();
    foreach ($this->gamesData AS $game) {
      $gameInfo = array();
      $gameInfo['id'] = $game->getId();
      $gameInfo['name'] = $game->getName();
      $gameInfo['hasStarted'] = $game->getHasStarted();
      $gamesList[] = $gameInfo;
    }
    return $gamesList;
  }

}
