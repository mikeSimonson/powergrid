<?php

namespace PowerGrid\Services\AuctionServices;

class AuctionServices {

  protected $gameData;

  public function __construct(\PowerGrid\Interfaces\GameData $gameData) {
    $this->gameData = $gameData;
  }

  public function setupStartingAuction() {
  }
}
