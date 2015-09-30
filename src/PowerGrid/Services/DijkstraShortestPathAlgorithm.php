<?php

namespace \PowerGrid\Services;

class DijkstraShortestPathAlgorithm implements \PowerGrid\Interfaces\ShortestPathFinder {
  
  protected $currentNode;
  protected $startNode;
  protected $endNode;


  protected $visitedSet;
  protected $unvisitedSet;

  protected $startDistanceMap;

  protected $nodeTenativeDistanceMap;
  protected $overallTentativeDistance;

  public function setStartNode(\PowerGrid\Services\GraphNode $startNode) {
    $this->startNode = $startNode;
    $this->startDistanceMap[$startNode->getId()] = 0;
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

      $this->markCurrentNodeAsVisited();
      $this->setNextCurrentNode();
    }
    
    return $this->overallTentativeDistance;
  }

  private function markVisited($node) {
    $this->visitedSet[$node->getId()] = TRUE;
  }

  private function markCurrentNodeAsVisited() {
    if (!in_array($this->currentNode->getId(), $this->visitedSet)) {
      $this->visitedSet[] = $this->currentNode->getId();
    }
  }

  private function checkForNewTenativeDistance($neighbor) {
    $distanceToCurrentFromStart = $this->getDistanceToStartNode($this->currentNode);
    $distanceFromCurrentToNeighbor = $this->currentNode->getConnectionWeightForNeighbor($neighbor);

    $totalDistanceFromStartToNeighbor = $distanceToCurrentFromStart + $distanceFromCurrentToNeighbor;

    $this->nodeTenativeDistanceMap[$neighbor->getId()] = $totalDistanceFromStartToNeighbor;

    if ($totalDistanceFromStartToNeighbor < $this->overallTentativeDistance) {
      $this->overallTentativeDistance = $totalDistanceFromStartToNeighbor;
    }
  }

  private function isUnvisited($neighbor) {
    if (!in_array($neighbor->getId(), $this->unvisitedSet)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  private function getDistanceToStartNode($node) {
    return $this->startDistanceMap[$node->getId()];
  }
}
