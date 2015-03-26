<?php

namespace \PowerGrid\Interfaces;

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
   * @param   int
   */ 
  public function placeBid($powerPlantId, $bidAmount);

  /**
   * @param array   $resource_name => $resource_quantity
   */
  public function buyResources($resourceOrder);

  /**
   * @param array
   */
  public function buildCities($cityNames);


  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  public function powerCities($quantity, $resourcePayment);
  
}
