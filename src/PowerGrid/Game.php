<?php

namespace \PowerGrid;

class Game implements \PowerGrid\Interfaces\GameControls {

  const NEW_TURN_ORDER_PHASE = 'new_turn_order';
  const PLACE_BID_PHASE = 'place_bid';
  const BUY_RESOURCES_PHASE = 'buy_resources';
  const BUILD_CITIES_PHASE = 'build_cities';
  const POWER_CITIES_PHASE = 'power_cities';

  /**
   * @param   obj     A proxy for the game data. 
   * @param   array   An assoc array with 
   */
  public function __construct(\PowerGrid\Interfaces\GameData $dataSource, \PowerGrid\Abstract\RuleFactory $ruleFactory) {
    $this->gameData = $dataSource;
    $this->ruleFactory = $ruleFactory;

    // Shuffle and create card stack
  }

  /**
   * Should give all info a player needs to make a strategic
   * play decision.
   * 
   * @param   void
   *
   * @return  array
   */
  public function getInfo() {

  }

  public function determineTurnOrder() {
  }

  /**
   * @param   int
   */
  public function startBid($powerPlantId) {
  }

  /**
   * @param   int
   * @param   int
   */ 
  public function placeBid($powerPlantId, $bidAmount) {
    $stepId = $this->gameData->getCurrentStepId();

    $bidRules = $this->makeStepRules($stepId);

    $turnData = new \Ruler\Context(array(
      'powerPlantId' => $powerPlantId,
      'bidAmount' => $bidAmount,
      'playerId' => $playerId
    ));

    $bidRules->execute($this->gameData, $turnData);
  }

  /**
   * @param array   $resource_name => $resource_quantity
   */
  public function buyResources($resourceOrder) {

  }

  /**
   * @param array
   */
  public function buildCities($cityNames) {

  }


  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($quantity, $resourcePayment) {

  }

  protected function makeStepRules($stepId) {
    $phaseId = $this->gameData->getCurrentPhaseId();

    $stepRules = $this->ruleFactory->getRules($stepId, $phaseId);

    return $stepRules;
  }
}
