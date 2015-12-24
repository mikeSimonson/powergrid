<?php

namespace PowerGrid\Abstracts;

abstract class Game implements \PowerGrid\Interfaces\GameControls, \PowerGrid\Interfaces\Observable {

  const ACTION_COMPLETE_EVENT_POSTFIX = ':COMPLETE';
  const EVENT_NAMESPACE = 'GameAction';
  
  protected $observers = array();

  protected $players = array();
  protected $ruleFactory = NULL;

  /**
   * @param   obj     A proxy for the game data. 
   * @param   obj     A rule factory.
   * @param   obj     An assoc array of \PowerGrid\Abstract\Player objs.
   */
  public function __construct(\PowerGrid\Interfaces\GameData $dataSource, \PowerGrid\Abstracts\GameProgression $gameProgression, \PowerGrid\Factories\RuleFactory $ruleFactory, \PowerGrid\Propositions $propositions) {
    $this->game = $dataSource;
    $this->propositions = $propositions;
    $this->ruleFactory = $ruleFactory;
    $this->gameProgression = $gameProgression;
    $this->setPlayers();
  }

  /**
   * @param   int
   */
  public function startBid(\PowerGrid\Interfaces\PlayerData $player, \PowerGrid\Interfaces\PowerPlantData $powerPlant, $bid) {
    $action = \PowerGrid\Interfaces\GameData::START_BID_ACTION;
    $context = array(
      'player' => $player,
      'powerPlant' => $powerPlant,
      'bid' => $bid
    );
    $this->performAction($action, $context);
  }

  /**
   * @param   int
   */
  public function passOnBidding(\PowerGrid\Interfaces\PlayerData $player, \PowerGrid\Interfaces\PowerPlantData $powerPlant) {
    // This is how a user says they don't want to bid
  }

  /**
   * @param   int
   * @param   int
   */ 
  public function placeBid(\PowerGrid\Interfaces\PlayerData $player, \PowerGrid\Interfaces\PowerPlantData $powerPlant, $bidAmount) {
    $action = \PowerGrid\Interfaces\GameData::PLACE_BID_ACTION;
    $context = array(
      'playerId' => $player,
      'powerPlantId' => $powerPlant,
      'bidAmount' => $bidAmount
    );
    $this->performAction($action, $context);
  }

  /**
   * @param array   $resource_name => $resource_quantity
   */
  public function buyResources($playerId, $resourceOrder) {
    $action = \PowerGrid\Interfaces\GameData::BUY_RESOURCES_ACTION;
    $context = array(
      'playerId' => $playerId,
      'resourceOrder' => $resourceOrder
    );
    $this->performAction($action, $context);
  }

  /**
   * @param array
   */
  public function buildCities($playerId, $cityNames) {
    $action = \PowerGrid\Interfaces\GameData::BUILD_CITIES_ACTION;
    $context = array(
      'playerId' => $playerId,
      'cityNames' => $cityNames
    );
    $this->performAction($action, $context);
  }

  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($playerId, $quantity, $resourcePayment) {
    $action = \PowerGrid\Interfaces\GameData::POWER_CITIES_ACTION;
    $context = array(
      'playerId' => $playerId,
      'quantity' => $quantity,
      'resourcePayment' => $resourcePayment
    );
    $this->performAction($action, $context);
  }

  protected function setPlayers() {
    foreach ($this->game->getPlayers() AS $player) {
      $this->players[$player->getId()] = $player;
    }
  }

  protected function performAction($action, $contextMap) {
    $this->beginAction($action);

    $rules = $this->getRules($action);
    $turnData = new \Ruler\Context($contextMap);
    $rules->execute($this->game, $turnData);

    $this->completeAction($action, $contextMap, $rules);
  }

  protected function getRules($action) {
    $stepId = $this->game->getStepNumber();
    $rules = $this->ruleFactory->makeRules($stepId, $action);

    return $rules;
  }

  protected function notifyNextPlayer() {
    /*
      @TODO: Come up with way to sanely notify next player
     */

    /*
    $nextPlayerId = $this->game->getNextPlayerId();
    $nextAction = $this->game->getNextPhaseId();

    $this->players[$nextPlayerId]->notify($nextAction);
     */
  }

  protected function beginAction($action) {
    $this->beginActionHook();
  }

  protected function completeAction($action, $contextMap, $rules) {
    $this->progressGame($action, $contextMap, $rules);
    $this->notifyNextPlayer();
    $this->completeActionHook();
  }

  protected function progressGame($action, $contextMap, $rules) {
    $event = \PowerGrid\Structures\Event::create(
      $action . static::ACTION_COMPLETE_EVENT_POSTFIX,
      static::EVENT_NAMESPACE,
      $contextMap,
      $rules->getLastExecutionStatus()
    );

    foreach ($this->observers AS $observer) {
      $observer->notify($event);
    }
  }

  public function subscribe(\PowerGrid\Interfaces\Observer $observer) {
    $this->observers[] = $observer;
  }

  /**
   * Run at the start of any action.
   *
   * @param   void
   * @return  void
   */
  abstract protected function beginActionHook();

  /**
   * Run at the end of any action, but before the next player is notified
   * of his/her next action (since notifying a player is not part of an
   * action).
   */
  abstract protected function completeActionHook();
}
