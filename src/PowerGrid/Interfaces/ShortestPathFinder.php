<?php

namespace PowerGrid\Interfaces;

interface ShortestPathFinder {
  public function setStartNode(\PowerGrid\Services\GraphNode $startNode);
  public function setEndNode(\PowerGrid\Services\GraphNode $endNode);
  public function getShortestPath();
}
