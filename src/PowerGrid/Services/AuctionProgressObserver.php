<?php

namespace PowerGrid\Services;

class AuctionProgressObserver implements \PowerGrid\Interfaces\Observer {
  protected $startBidEvent;
  protected $placeBidEvent;
  protected $eventNamespace;
  protected $auctionStarter;

  public function __construct(\PowerGrid\Interfaces\GameData $game, \PowerGrid\Abstracts\AuctionStarter $auctionStarter) {
    $this->game = $game;
    $this->auctionStarter = $auctionStarter;
    $this->startBidEvent = \PowerGrid\Interfaces\GameData::START_BID_ACTION . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX;
    $this->placeBidEvent = \PowerGrid\Interfaces\GameData::PLACE_BID_ACTION . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX;
    $this->eventNamespace = \PowerGrid\Abstracts\Game::EVENT_NAMESPACE;
  }

  public function notify(\PowerGrid\Structures\Event $event) {
    if ($event->getNamespace() == $this->eventNamespace) {
      if ($event->getName() == $this->startBidEvent) {
        $this->auctionStarter->startAuctionRound($event->getObject());
      }
      else if ($event->getName() == $this->placeBidEvent) {
        $this->auctionStarter->updateAuctionRound($event->getObject());
      }
    }
  }
}
