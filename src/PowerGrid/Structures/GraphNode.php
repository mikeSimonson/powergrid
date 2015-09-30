<?php

namespace PowerGrid\Structures;

class GraphNode {
  protected $neighbors;
  protected $neighborConnectionWeights;
  protected $id;

  public function __construct($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function addNeighbor(\PowerGrid\Structures\GraphNode &$newNeighbor, $weight) {
    if (isset($this->neighbors[$newNeighbor->getId()])) {
      throw new \PowerGrid\Exceptions\Application\NeighborAlreadyExistsForGraphNode($this->getId(), $newNeighbor->getId());
    }
    $this->neighbors[$newNeighbor->getId()] = $newNeighbor;
    $this->neighborConnectionWeights[$newNeighbor->getId()] = $weight;
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

  public function getNeighbors() {
    return $this->neighbors;
  }
}
