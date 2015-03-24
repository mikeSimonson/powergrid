<?php

abstract class AbstractGame {

  /**
   * Should give all info a player needs to make a strategic
   * play decision.
   * 
   * @param   void
   *
   * @return  array
   */
  abstract public function getInfo();

  /**
   * @param   int
   * @param   int
   */ 
  abstract public function placeBid($powerPlantId, $bidAmount);

  /**
   * @param array   $resource_name => $resource_quantity
   */
  abstract public function buyResources($resourceOrder);

  /**
   * @param array
   */
  abstract public function buildCities($cityNames);


  /**
   * @param   int
   * @param   array   $resource_name => $resource_quantity
   */
  abstract public function powerCities($quantity, $resourcePayment);
  
}
