<?php

namespace PowerGrid\Services;

class DijkstraShortestPathAlgorithm implements \PowerGrid\Interfaces\ShortestPathFinder {
  
  protected $currentNode;
  protected $startNode;
  protected $endNode;

  protected $unvisitedSet;

  protected $nodeTentativeDistances;
  protected $startDistanceMap;

  protected $nodeGraph;

  public function __construct(\PowerGrid\Interfaces\WeightedUndirectedGraph $nodeGraph) {
    $this->nodeGraph = $nodeGraph;
    $this->initialize();
  }

  private function setNodes(Array $nodes) {
    foreach ($nodes AS $node) {
      if (!($node instanceof \PowerGrid\Structures\GraphNode)) {
        throw new \PowerGrid\Exceptions\Application\UnexpectedParameterType('Expected array where each item is a \PowerGrid\Structures\GraphNode object in ' . __METHOD__);
      }

      $this->addNode($node);
    }
  }

  public function initialize() {
    $this->nodeTentativeDistances = new \SplPriorityQueue();
    
    $this->currentNode = NULL;

    $this->unvisitedSet = array();

    $this->startDistanceMap = array();

    $this->setNodes($this->nodeGraph->getNodes());
  }

  private function addNode(\PowerGrid\Structures\GraphNode $node) {
    $this->markUnvisited($node);
    $this->setTentativeDistanceForNode(INF, $node);
  }

  public function setStartNode(\PowerGrid\Structures\GraphNode $startNode) {
    $this->startNode = $startNode;
    $this->setTentativeDistanceForNode(0, $this->startNode);
    $this->markVisited($startNode);
    $this->currentNode = $this->startNode;
  }

  public function setEndNode(\PowerGrid\Structures\GraphNode $endNode) {
    $this->endNode = $endNode;
  }

  public function calculateShortestPath() {
    while ($this->isUnvisited($this->endNode)) {
      foreach ($this->currentNode->getNeighbors() AS $neighbor) {
        if ($this->isUnvisited($neighbor)) {
          $this->checkForNewTenativeDistance($neighbor);
        }
      }

      $this->markVisited($this->currentNode);
      $this->setNextCurrentNode();
    }
    
    return $this->getDistanceToStartNode($this->endNode);
  }

  private function setNextCurrentNode() {
    $nextCurrentNodeId = $this->getLowestTentativeDistanceNodeId();
    $nextCurrentNode = $this->nodeGraph->getMatchingNode($nextCurrentNodeId);
    $this->currentNode = $nextCurrentNode;
  }

  private function getLowestTentativeDistanceNodeId() {
    return $this->nodeTentativeDistances->extract();
  }

  private function isUnvisited(\PowerGrid\Structures\GraphNode $node) {
    return $this->unvisitedSet[$node->getId()] === TRUE;
  }

  private function markVisited(\PowerGrid\Structures\GraphNode $node) {
    $this->unvisitedSet[$node->getId()] = FALSE;
  }

  private function markUnvisited(\PowerGrid\Structures\GraphNode $node)  {
    $this->unvisitedSet[$node->getId()] = TRUE;
  }

  private function checkForNewTenativeDistance(\PowerGrid\Structures\GraphNode $node) {
    $distanceToCurrentFromStart = $this->getDistanceToStartNode($this->currentNode);
    $distanceFromCurrentToNeighbor = $this->currentNode->getConnectionWeightForNeighbor($node);

    $totalDistanceFromStartToNeighbor = $distanceToCurrentFromStart + $distanceFromCurrentToNeighbor;

    if ($this->distanceIsLessThanTentativeForNode($totalDistanceFromStartToNeighbor, $node)) {
      $this->setTentativeDistanceForNode($totalDistanceFromStartToNeighbor, $node);
    }
  }

  private function distanceIsLessThanTentativeForNode($distance, \PowerGrid\Structures\GraphNode $node) {
    $result = FALSE;

    $currentTentativeDistance = $this->startDistanceMap[$node->getId()];
    if ($currentTentativeDistance === NULL || $distance < $currentTentativeDistance) {
      $result = TRUE;
    }

    return $result;
  }

  private function setTentativeDistanceForNode($distance, \PowerGrid\Structures\GraphNode $node) {
    $this->nodeTentativeDistances->insert($node->getId(), $distance);
    $this->startDistanceMap[$node->getId()] = $distance;
  }

  private function getDistanceToStartNode(\PowerGrid\Structures\GraphNode $node) {
    return $this->startDistanceMap[$node->getId()];
  }

}
