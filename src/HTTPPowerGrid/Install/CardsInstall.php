<?php

namespace HTTPPowerGrid\Install;

class CardsInstall {
  protected $config;
  protected $cardSet;
  protected $resourceTypesConfigToDBMap;

  /**
   * As of right now, the resources must be installed first, so that we can 
   * link resource types up with cards. I actually don't see this changing, ever.
   */
  public function __construct($config, \CardSet $cardSet, $resourceTypesConfigToDBMap) {
    $this->config = $config;
    $this->cardSet = $cardSet;
    $this->resourceTypesConfigToDBMap = $resourceTypesConfigToDBMap;
  }

  public function installCards() {
    foreach ($this->config AS $cardConfig) {
      $dbCard = new \Card();

      $dbCard->setCardSet($this->cardSet);

      // Add the types of resources allowed for this card.
      foreach ($cardConfig['resource_types'] AS $resourceTypeConfigId) {
        $dbResourceType = $this->resourceTypesConfigToDBMap[$resourceTypeConfigId];
        $dbCard->addCardResourceType($dbResourceType);
      }

      $dbCard->setStartingAuctionPrice($cardConfig['starting_auction_price']);
      $dbCard->setResourceCost($cardConfig['resource_cost']);
      $dbCard->setPowerOutput($cardConfig['power_output']);

      $dbCard->save();
    }
  }
}
