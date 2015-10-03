<?php

class DijkstraShortestPathAlgorithmTest extends PHPUnit_Framework_TestCase {

  /**
   * @dataProvider graphProvider 
   */
  public function testShortestPathCalculatedProperly($graph, $startNodeId, $endNodeId, $correctDistance) {
    $algorithm = new \PowerGrid\Services\DijkstraShortestPathAlgorithm($graph);

    $algorithm->setNodes($graph->getNodes());

    $algorithm->setStartNode($graph->getMatchingNode($startNodeId));
    $algorithm->setEndNode($graph->getMatchingNode($endNodeId));

    $calculatedDistance = $algorithm->calculateShortestPath();

    $this->assertEquals($calculatedDistance, $correctDistance);
  }

  public function graphProvider() {
    return array(
      $this->graphProviderCase1()
    );
  }

  private function graphProviderCase1() {
    $graph = new \PowerGrid\Structures\CityConnectionsGraph();

    $nodes = array();

    for ($i = 0; $i < 7; ++$i) {
      $nodes[] = new \PowerGrid\Structures\GraphNode($i);
    }

    $node0Neighbors = array(
      array($nodes[1], 4),
      array($nodes[2], 3),
      array($nodes[4], 7)
    );
    $nodes[0]->addNeighbors($node0Neighbors);

    $node1Neighbors = array(
      array($nodes[0], 4),
      array($nodes[2], 6),
      array($nodes[3], 5)
    );
    $nodes[1]->addNeighbors($node1Neighbors);

    $node2Neighbors = array(
      array($nodes[0], 3),
      array($nodes[1], 6),
      array($nodes[3], 11),
      array($nodes[4], 8)
    );
    $nodes[2]->addNeighbors($node2Neighbors);

    $node3Neighbors = array(
      array($nodes[1], 5),
      array($nodes[2], 11),
      array($nodes[4], 2),
      array($nodes[5], 2),
      array($nodes[6], 10)
    );
    $nodes[3]->addNeighbors($node3Neighbors);

    $node4Neighbors = array(
      array($nodes[0], 7),
      array($nodes[2], 8),
      array($nodes[3], 2),
      array($nodes[6], 5)
    );
    $nodes[4]->addNeighbors($node4Neighbors);

    $node5Neighbors = array(
      array($nodes[3], 2),
      array($nodes[6], 3)
    );
    $nodes[5]->addNeighbors($node5Neighbors);

    $node6Neighbors = array(
      array($nodes[3], 10),
      array($nodes[4], 5),
      array($nodes[5], 3)
    );
    $nodes[6]->addNeighbors($node6Neighbors);

    $graph->populateFromIncompleteGraphNodes($nodes);

    $startingNodeId = 0;
    $goalNodeId = 5;
    $correctDistance = 11;

    return array($graph, $startingNodeId, $goalNodeId, $correctDistance);
  }

  private function graphProviderCase2() {
    $graph = new \PowerGrid\Structures\CityConnectionsGraph();

    $nodes = array();

    for ($i = 0; $i < 2; ++$i) {
      $nodes[] = new \PowerGrid\Structures\GraphNode($i);
    }

    $node0Neighbors = array(
      array($nodes[1], 1)
    );
    $nodes[0]->addNeighbors($node0Neighbors);

    $startingNodeId = 0;
    $goalNodeId = 1;
    $correctDistance = 1;

    $graph->populateFromIncompleteGraphNodes($nodes);

    return array($graph, $startingNodeId, $goalNodeId, $correctDistance);
  }

}
