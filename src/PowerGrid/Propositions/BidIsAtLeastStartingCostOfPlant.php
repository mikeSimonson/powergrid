<?php

namespace PowerGrid\Propositions;

class BidIsAtLeastStartingCostOfPlant implements \Ruler\Proposition {
  public function evaluate(\Ruler\Context $context) {
    $bid = $context['bid'];
    $powerPlant = $context['powerPlant'];

    $result = intval($bid) >= $powerPlant->getStartingAuctionPrice();

    return $result;
  }
}
