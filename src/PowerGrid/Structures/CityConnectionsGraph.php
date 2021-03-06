<?php

namespace PowerGrid\Structures;

class CityConnectionsGraph implements \PowerGrid\Interfaces\WeightedUndirectedGraph {

  protected $cityNodeRefHash;

  public function populateFromIncompleteGraphNodes(Array $incompleteGraph) {
    $this->saveNodeRefs($incompleteGraph);
    $this->buildFullGraph();
  }

  public function getNodes() {
    return $this->cityNodeRefHash;
  }

  public function getMatchingNode($requestedNode = NULL) {
    $startNode = NULL;

    if ($requestedNode instanceof \PowerGrid\Structures\GraphNode && isset($this->cityNodeRefHash[$requestedNode->getId()])) {
      $startNode = $this->cityNodeRefHash[$requestedNode->getId()];
    }
    else if (is_numeric($requestedNode)) {
      $startNode = $this->cityNodeRefHash[$requestedNode];
    }
    else if ($requestedNode === NULL) {
      $startNode = array_rand($this->cityNodeRefHash);
    }
    else {
      throw new \PowerGrid\Exceptions\Application\RequestedStartNodeNotInGraph();
    }

    return $startNode;
  }

  protected function saveNodeRefs(Array &$nodes) {
    foreach ($nodes AS $node) {
      if (!isset($this->cityNodeRefHash[$node->getId()])) {
        $this->cityNodeRefHash[$node->getId()] = $node;
      }
    }
  }

  protected function buildFullGraph() {
    foreach ($this->cityNodeRefHash AS $cityNode) {
      $this->connectNeighborsBackToTarget($cityNode);
    }
  }

  /**
   * Make the connections between a node and its neighbors undirected (bidirectional).
   */
  private function connectNeighborsBackToTarget($target) {
    $neighbors = $target->getNeighbors();
    $this->saveNodeRefs($neighbors);
    foreach ($neighbors AS $neighbor) {
      $neighbor->addNeighbor($target, $target->getConnectionWeightForNeighbor($neighbor));
    }
  }

  public function print_representation() {
    $print_array = array();
    foreach ($this->cityNodeRefHash AS $cityNode) {
      $parentName = $cityNode->getName() . ':' . $cityNode->getId();
      $print_array[$parentName] = array();
      foreach ($cityNode->getNeighbors() AS $neighbor) {
        $neighborName = $neighbor->getName() . ':' . $neighbor->getId();
        $print_array[$parentName][$neighborName] = $cityNode->getConnectionWeightForNeighbor($neighbor);
      }
    }
    return $print_array;
  }
}
