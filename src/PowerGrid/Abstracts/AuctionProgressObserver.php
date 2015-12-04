<?php

namespace PowerGrid\Abstracts;

abstract class AuctionProgressObserver implements \PowerGrid\Interfaces\Observer {
  protected $startBidEvent;
  protected $placeBidEvent;
  protected $eventNamespace;

  public function __construct(\PowerGrid\Interfaces\GameData $game) {
    $this->game = $game;
    $this->startBidEvent = \PowerGrid\Interfaces\GameData::START_BID_ACTION . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX;
    $this->placeBidEvent = \PowerGrid\Interfaces\GameData::PLACE_BID_ACTION . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX;
    $this->eventNamespace = \PowerGrid\Abstracts\Game::EVENT_NAMESPACE;
  }

  public function notify(\PowerGrid\Structures\Event $event) {
    if ($event->getNamespace() == $this->eventNamespace) {
      if ($event->getName() == $this->startBidEvent) {
        $this->startAuction($event->getObject());
      }
      else if ($event->getName() == $this->placeBidEvent) {
        $this->updateAuction($event->getObject());
      }
    }
  }

  protected function startAuction(Array $eventObject) {
    $currentAuctionPlant = $this->createCurrentAuctionPlant($eventObject);
    foreach ($this->game->getPlayers() AS $player) {
      $this->createAuctionActionForPlayer($player, $currentAuctionPlant, $eventObject);
    }
  }

  protected function updateAuction(Array $eventObject) {
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
}
