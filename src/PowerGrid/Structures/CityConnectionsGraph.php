<?php

namespace PowerGrid\Structures;

class CityConnectionsGraph implements \PowerGrid\Interfaces\WeightedUndirectedGraph {

  protected $cityNodeRefHash;

  public function populateFromIncompleteGraphNodes(Array $incompleteGraph) {
    $this->saveNodeRefs($incompleteGraph);
    $this->buildFullGraph();
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
    $this->saveNodeRefs($target->getNeighbors());
    foreach ($target->getNeighbors() AS $neighbor) {
      $neighbor->addNeighbor($target, $target->getConnectionWeightForNeighbor($neighbor));
    }
  }
}
