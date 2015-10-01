<?php

namespace \PowerGrid\Services;

class DijkstraShortestPathAlgorithm implements \PowerGrid\Interfaces\ShortestPathFinder {
  
  protected $currentNode;
  protected $startNode;
  protected $endNode;


  protected $visitedSet;
  protected $unvisitedSet;

  protected $nodeTenativeDistanceMap;

  public function setNodes(Array $nodes) {
    foreach ($nodes AS $node) {
      if (is_numeric($node)) {
        $nodeId = $node;
      }
      else if ($node instanceof \PowerGrid\Services\GraphNode) {
        $nodeId = $node->getId();
      }
      else {
        throw new \PowerGrid\Exceptions\Application\UnexpectedParameterType('Expected array where each item is a numerical id or \PowerGrid\Services\GraphNode object in ' . __METHOD__);
      }

      $this->addNode($nodeId);

    }
  }

  public function reset() {
    $this->currentNode = NULL;
    $this->startNode = NULL;
    $this->endNode = NULL;

    $this->visitedSet = array();
    $this->unvisitedSet = array();

    $this->nodeTenativeDistanceMap = array();
  }

  private function addNode($nodeId) {
    $this->unvisitedSet[$nodeId] = TRUE;
    $this->visitedSet[$nodeId] = FALSE;
    $this->nodeTenativeDistanceMap[$nodeId] = NULL;
  }

  public function setStartNode(\PowerGrid\Services\GraphNode $startNode) {
    $this->startNode = $startNode;
    $this->nodeTenativeDistanceMap[$startNode->getId()] = 0;
    $this->markVisited($startNode);
    $this->currentNode = $this->startNode;
  }

  public function setEndNode(\PowerGrid\Services\GraphNode $endNode) {
    $this->endNode = $endNode;
  }

  public function getShortestPath() {
    while (!in_array($this->endNode->getId(), $this->visitedSet)) {
      foreach ($this->currentNode->getNeighbors() AS $neighbor) {
        if ($this->isUnvisited($neighbor)) {
          $this->checkForNewTenativeDistance($neighbor);
        }
      }

      $this->markVisited($this->currentNode);
      $this->setNextCurrentNode();
    }
    
    return $this->overallTentativeDistance;
  }

  private function markVisited($node) {
    $this->visitedSet[$node->getId()] = TRUE;
    $this->unvisitedSet[$node->getId()] = FALSE;
  }

  private function checkForNewTenativeDistance($node) {
    $distanceToCurrentFromStart = $this->getDistanceToStartNode($this->currentNode);
    $distanceFromCurrentToNeighbor = $this->currentNode->getConnectionWeightForNeighbor($node);

    $totalDistanceFromStartToNeighbor = $distanceToCurrentFromStart + $distanceFromCurrentToNeighbor;

    $this->nodeTenativeDistanceMap[$node->getId()] = $totalDistanceFromStartToNeighbor;

    if ($this->distanceIsLessThanTentativeForNode($totalDistanceFromStartToNeighbor, $node)) {
      $this->setTentativeDistanceForNode($totalDistanceFromStartToNeighbor, $node);
    }
  }

  private function distanceIsLessThanTentativeForNode($distance, $node) {
    $result = FALSE;

    $currentTentativeDistance = $this->nodeTenativeDistanceMap[$node->getId()];
    if ($currentTentativeDistance === NULL || $distance < $currentTentativeDistance) {
      $result = TRUE;
    }

    return $result;
  }

  private function setTentativeDistanceForNode($distance, $node) {
    $this->nodeTenativeDistanceMap[$node->getId()] = $distance;
  }

  private function isUnvisited($neighbor) {
    return $this->unvisitedSet[$neighbor->getId()];
  }

  private function getDistanceToStartNode($node) {
    return $this->startDistanceMap[$node->getId()];
  }
}
