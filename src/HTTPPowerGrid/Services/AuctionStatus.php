<?php

namespace HTTPPowerGrid\Services;

class AuctionStatus extends \PowerGrid\Abstracts\AuctionStatus {
  public function isComplete() {
    $auctionComplete = FALSE;

    // Auction is complete when all but the highest bidder have passed.
    $playersWhoHavePassed = \PlayerAuctionActionQuery::create()
      ->filterByGame($this->game)
      ->filterByHasPassed(TRUE)
      ->orderBy('round_number', Criteria::Desc)
      ->limit($this->game->countPlayers())
      ->find();

    if (count($playersWhoHavePassed) == $this->game->countPlayers() - 1) {
      $auctionComplete = TRUE;
    }

    return $auctionComplete;
  }
}
