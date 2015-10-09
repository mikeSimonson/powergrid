<?php

namespace PowerGrid\Structures;

class GraphNode {
  protected $neighbors;
  protected $neighborConnectionWeights;
  protected $id;
  protected $name;

  public function __construct($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function addNeighbor(\PowerGrid\Structures\GraphNode &$newNeighbor, $weight) {
    if (!isset($this->neighbors[$newNeighbor->getId()])) {
      $this->neighbors[$newNeighbor->getId()] = $newNeighbor;
      $this->neighborConnectionWeights[$newNeighbor->getId()] = $weight;
    }
  }

  public function addNeighbors(Array &$neighborsAndWeights) {
    foreach ($neighborsAndWeights AS $neighborAndWeight) {
      $neighbor = $neighborAndWeight[0];
      $weight = $neighborAndWeight[1];

      $this->addNeighbor($neighbor, $weight);
    }
  }

  public function getConnectionWeightForNeighbor($neighbor) {
    if (!isset($this->neighborConnectionWeights[$neighbor->getId()])) {
      throw new \PowerGrid\Exceptions\Application\GraphNodeNeighborWeightNotFound($this->getId(), $neighbor->getId());
    }

    return $this->neighborConnectionWeights[$neighbor->getId()];
  }

  public function isNeighbor(\PowerGrid\Structures\GraphNode $node) {
    $isNeighbor = FALSE;

    if (isset($this->neighbors[$node->getId()])) {
      $isNeighbor = TRUE;
    }

    return $isNeighbor;
  }

  public function &getNeighbors() {
    return $this->neighbors;
  }
  public function setName($name) {
    $this->name = $name;
  }
}
