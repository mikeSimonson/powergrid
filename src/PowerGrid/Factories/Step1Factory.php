<?php

namespace \PowerGrid\Factories;

class Step1Factory {

  public function makeActionRuleset($action) {
    $actionRuleset;

    switch ($action) {
    case (\PowerGrid\Interfaces\GameData::NEW_TURN_ORDER_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\NewTurnOrder();
      break;
    case (\PowerGrid\Interfaces\GameData::START_BID_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\StartBidAction();
      break;
      break;
    case (\PowerGrid\Interfaces\GameData::PLACE_BID_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\PlaceBidAction();
      break;
    case (\PowerGrid\Interfaces\GameData::BUY_RESOURCES_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\BuyResourcesAction();
      break;
    case (\PowerGrid\Interfaces\GameData::BUILD_CITIES_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\BuildCitiesAction();
      break;
    case (\PowerGrid\Interfaces\GameData::POWER_CITIES_ACTION):
      $actionRuleset = new \PowerGrid\Rulesets\Step1\PowerCitiesAction();
      break;
    default:
      throw new Exception("No rulset for action $action in Step 1");
      break;
    }
  }
}
