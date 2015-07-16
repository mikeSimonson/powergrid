<?php

namespace PowerGrid\Interfaces;

interface GameData {
  const NEW_TURN_ORDER_ACTION = 'new_turn_order';
  const START_BID_ACTION = 'start_bid';
  const PLACE_BID_ACTION = 'place_bid';
  const BUY_RESOURCES_ACTION = 'buy_resources';
  const BUILD_CITIES_ACTION = 'build_cities';
  const POWER_CITIES_ACTION = 'power_cities';

  const MIN_PLAYERS = 2;
  const MAX_PLAYERS = 6;

  const STARTING_PLAYER_WALLET_BALANCE = 50;

  /* GETTERS */

  public function getId();

  public function getName();

  public function getPhaseNumber();

  public function getStepNumber();

  public function getNextPlayer();

  public function getPlayers();

  public function getHasStarted();

  /* MUTATORS */

  public function startGameForCallingUserId($callingUserId);
}
