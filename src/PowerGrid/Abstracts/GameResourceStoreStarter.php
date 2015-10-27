<?php

namespace PowerGrid\Abstracts;

abstract class GameResourceStoreStarter {

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
  }

  public function setup() {
    foreach ($this->getStartingResourceSchedule() AS $resourceName => $quantity) {
      $this->addResourceToGame($resourceName, $quantity);
    }
  }

  protected function getStartingResourceSchedule() {
    return array(
      'coal' => 24,
      'oil' => 18,
      'nuke' => 2,
      'trash' => 6
    );
  }

  abstract protected function addResourceToGame($name, $quantity);
}
