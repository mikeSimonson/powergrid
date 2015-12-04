<?php

namespace PowerGrid;

class GameManager implements \PowerGrid\Interfaces\GameControls {
  protected $gameController;

  public function __construct(\PowerGrid\Abstracts\Game $gameController, \PowerGrid\Abstracts\NextPlayerObserver $nextPlayerObserver, \PowerGrid\Abstracts\AuctionProgressObserver $auctionProgressObserver) {
    $this->gameController = $gameController;
    $this->nextPlayerObserver = $nextPlayerObserver;
    $this->auctionProgressObserver = $auctionProgressObserver;
    $this->setUpObservers();
  }

  protected function setUpObservers() {
    $this->gameController->subscribe($this->nextPlayerObserver);
    $this->gameController->subscribe($this->auctionProgressObserver);
  }

  public function startBid($playerId, $powerPlantId, $bidAmount) {
    $this->gameController->startBid($playerId, $powerPlantId, $bidAmount);
  }

  public function placeBid($playerId, $powerPlantId, $bidAmount) {
    $this->gameController->placeBid($playerId, $powerPlantId, $bidAmount);
  }

  public function buyResources($playerId, $resourceOrder) {
    $this->gameController->buyResources($playerId, $resourceOrder);
  }

  public function buildCities($playerId, $cityNames) {
    $this->gameController->buildCities($playerId, $cityNames);
  }

  public function powerCities($playerId, $quantity, $resourcePayment) {
    $this->gameController->powerCities($playerId, $quantity, $resourcePayment);
  }
}
