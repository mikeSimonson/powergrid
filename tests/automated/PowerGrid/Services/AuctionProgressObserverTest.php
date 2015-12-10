<?php

class AuctionProgressObserverTest extends PHPUnit_Framework_TestCase {
  
  public function setUp() {
    $this->game = \Mockery::mock('\PowerGrid\Interfaces\GameData');
  }

  public function tearDown() {
    \Mockery::close();
  }

  public function testStartsAuctionWhenReceivingStartAuctionNotification() {
    $startBidEvent = \Mockery::mock('\PowerGrid\Structures\Event');
    $startBidEvent
      ->shouldReceive('getNamespace')
      ->once()
      ->andReturn(\PowerGrid\Abstracts\Game::EVENT_NAMESPACE);
    $startBidEvent
      ->shouldReceive('getName')
      ->once()
      ->andReturn(\PowerGrid\Interfaces\GameData::START_BID_ACTION . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX);
    $startBidEvent
      ->shouldReceive('getObject')
      ->once()
      ->andReturn(array());

    $auctionStarter = \Mockery::mock('\PowerGrid\Abstracts\AuctionStarter');

    $auctionStarter
      ->shouldReceive('startAuctionRound')
      ->once()
      ->andReturn(NULL);

    $auctionProgressObserver = new \PowerGrid\Services\AuctionProgressObserver($this->game, $auctionStarter);

    $auctionProgressObserver->notify($startBidEvent);
  }

  public function testUpdatesAuctionWhenReceivingUpdateAuctionNotification() {
    $updateAuctionEvent = \Mockery::mock('\PowerGrid\Structures\Event');
    $updateAuctionEvent
      ->shouldReceive('getNamespace')
      ->once()
      ->andReturn(\PowerGrid\Abstracts\Game::EVENT_NAMESPACE);
    $updateAuctionEvent
      ->shouldReceive('getName')
      ->atLeast()
      ->times(1)
      ->andReturn(\PowerGrid\Interfaces\GameData::PLACE_BID_ACTION . \PowerGrid\Abstracts\Game::ACTION_COMPLETE_EVENT_POSTFIX);
    $updateAuctionEvent
      ->shouldReceive('getObject')
      ->once()
      ->andReturn(array());

    $auctionStarter = \Mockery::mock('\PowerGrid\Abstracts\AuctionStarter');

    $auctionStarter
      ->shouldReceive('updateAuctionRound')
      ->once()
      ->andReturn(NULL);

    $auctionProgressObserver = new \PowerGrid\Services\AuctionProgressObserver($this->game, $auctionStarter);

    $auctionProgressObserver->notify($updateAuctionEvent);
  }
}
