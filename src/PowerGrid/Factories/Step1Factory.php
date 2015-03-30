<?php

namespace \PowerGrid\Factories;

class Step1Factory {

  public function makeActionRuleset($action) {
    $actionRuleset;

    switch ($action) {
    case (Game::NEW_TURN_ORDER_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\NewTurnOrder();
      break;
    case (Game::START_BID_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\StartBidAction();
      break;
      break;
    case (Game::PLACE_BID_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\PlaceBidAction();
      break;
    case (Game::BUY_RESOURCES_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\BuyResourcesAction();
      break;
    case (Game::BUILD_CITIES_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\BuildCitiesAction();
      break;
    case (Game::POWER_CITIES_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\PowerCitiesAction();
      break;
    default:
      throw new Exception("No rulset for action $action in Step 1");
      break;
    }
  }
}
