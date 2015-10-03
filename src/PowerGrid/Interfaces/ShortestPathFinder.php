<?php

namespace PowerGrid\Interfaces;

interface ShortestPathFinder {
  public function setStartNode(\PowerGrid\Structures\GraphNode $startNode);
  public function setEndNode(\PowerGrid\Structures\GraphNode $endNode);
  public function calculateShortestPath();
}
