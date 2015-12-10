<?php

namespace PowerGrid\Abstracts;

abstract class AuctionStarter {
  protected $game;
  protected $gameDeck;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Abstracts\GameDeckSearcher $gameDeck) {
    $this->game = $game;
    $this->gameDeck = $gameDeck;
  }

  public function setup() {
    $this->moveDeckCardsIntoAuction($this->gameDeck->getCheapestCards(8));
  }

  public function startAuctionRound(Array $eventObject) {
    $currentAuctionPlant = $this->createCurrentAuctionPlant($eventObject);
    foreach ($this->game->getPlayers() AS $player) {
      $this->createAuctionActionForPlayer($player, $currentAuctionPlant, $eventObject);
    }
  }

  public function updateAuction(Array $eventObject) {
    $player = $eventObject['player'];
    $this->updateAuctionActionForPlayer($player, $eventObject);
    $this->updateCurrentAuctionPlant($player, $eventObject);
    if ($this->auctionIsComplete($eventObject)) {
      $this->giveWinningPlayerCard($eventObject);
    }
  }

  abstract protected function createCurrentAuctionPlant($eventObject);
  
  abstract protected function updateCurrentAuctionPlant($player, $eventObject);

  abstract protected function createAuctionActionForPlayer($player, $eventObject);
  
  abstract protected function updateAuctionActionForPlayer($player, $eventObject);
  
  abstract protected function auctionIsComplete($eventObject);

  abstract protected function giveWinningPlayerCard($eventObject);

  abstract protected function moveDeckCardsIntoAuction($deckCards);
}
