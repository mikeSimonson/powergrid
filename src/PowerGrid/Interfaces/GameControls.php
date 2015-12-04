<?php

namespace PowerGrid\Interfaces;

interface GameControls {

  /**
   * @param   int
   * @param   int
   */
  public function startBid($playerId, $powerPlantId);

  /**
   * @param   int
   * @param   int
   * @param   int
   */ 
  public function placeBid($playerId, $powerPlantId, $bidAmount);

  /**
   * @param   int
   * @param array   $resource_name => $resource_quantity
   */
  public function buyResources($playerId, $resourceOrder);

  /**
   * @param   int
   * @param array
   */
  public function buildCities($playerId, $cityNames);


  /**
   * @param   int
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($playerId, $quantity, $resourcePayment);
}
