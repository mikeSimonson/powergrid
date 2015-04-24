<?php

namespace PowerGrid\Interfaces;

interface GameControls {

  /**
   * Should give all info a player needs to make a strategic
   * play decision.
   * 
   * @param   void
   *
   * @return  array
   */
  public function getInfo();

  /**
   * @param   int
   */
  public function startBid($playerId, $powerPlantId);

  /**
   * @param   int
   * @param   int
   */ 
  public function placeBid($playerId, $powerPlantId, $bidAmount);

  /**
   * @param array   $resource_name => $resource_quantity
   */
  public function buyResources($playerId, $resourceOrder);

  /**
   * @param array
   */
  public function buildCities($playerId, $cityNames);


  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($playerId, $quantity, $resourcePayment);
}
