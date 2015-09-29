<?php

namespace PowerGrid\Structures;

class CityNode {
  protected $neighbors;
  protected $neighborConnectionWeights;
  protected $id;

  public function __construct($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function addNeighbor(\PowerGrid\Structures\CityNode &$newNeighbor, $weight) {
    if (isset($this->neighbors[$newNeighbor->getId()])) {
      throw new \PowerGrid\Exceptions\Application\NeighborAlreadyExistsForCityNode($this->getId(), $newNeighbor->getId());
    }
    $this->neighbors[$newNeighbor->getId()] &= $newNeighbor;
    $this->neighborConnectionWeights[$newNeighbor->getId()] = $weight;
  }

  public function getConnectionWeightForNeighbor($neighbor) {
    if (!isset($this->neighborConnectionWeights[$neighbor->getId()])) {
      throw new \PowerGrid\Exceptions\Application\CityNodeNeighborWeightNotFound($this->getId(), $neighbor->getId());
    }

    return $this->neighborConnectionWeights[$neighbor->getId()];
  }

  public function isNeighbor(\PowerGrid\Structures\CityNode $node) {
    $isNeighbor = FALSE;

    if ($this->neighbors[$node->getId()] instanceof \PowerGrid\Structures\CityNode) {
      $isNeighbor = TRUE;
    }

    return $isNeighbor;
  }
}
