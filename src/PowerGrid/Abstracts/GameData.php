<?php

namespace PowerGrid\Abstracts;

interface GameData {
  const NEW_TURN_ORDER_ACTION = 'new_turn_order';
  const START_BID_ACTION = 'start_bid';
  const PLACE_BID_ACTION = 'place_bid';
  const BUY_RESOURCES_ACTION = 'buy_resources';
  const BUILD_CITIES_ACTION = 'build_cities';
  const POWER_CITIES_ACTION = 'power_cities';

  /* GETTERS */

  public function getCurrentPhaseId();

  public function getCurrentStepId();

  public function getNextPhaseId();

  public function getNextPlayerId();

  /* SETTERS */

  public function setPlayerIds($playerIds);
}
