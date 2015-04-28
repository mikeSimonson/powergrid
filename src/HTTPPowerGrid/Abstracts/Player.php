<?php

namespace HTTPPowerGrid\Abstracts;

abstract class Player extends \Player implements \PowerGrid\Interfaces\Player {

  public function notify($action) {
    switch ($action) {
    case \PowerGrid\Abstracts\GameData::START_BID_ACTION:
      $this->startBid();
      break;
    case \PowerGrid\Abstracts\GameData::PLACE_BID_ACTION:
      $this->placeBid();
      break;
    case \PowerGrid\Abstracts\GameData::BUY_RESOURCES_ACTION:
      $this->buyResources();
      break;
    case \PowerGrid\Abstracts\GameData::BUILD_CITIES_ACTION:
      $this->buildCities();
      break;
    case \PowerGrid\Abstracts\GameData::POWER_CITIES_ACTION:
      $this->powerCities();
      break;
    default:
      throw new \Exception("Player has no action for the notification $action");
    }
  }

  abstract protected function startBid();
  abstract protected function placeBid();
  abstract protected function buyResources();
  abstract protected function buildCities();
  abstract protected function powerCities();
}
