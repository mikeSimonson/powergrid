<?php

namespace HTTPPowerGrid\Install;

class MapInstall {

  protected $dbMap;
  protected $dbCities;
  protected $dbConnections;

  protected $mapConfig;
  protected $cityNames;
  protected $connectionsConfig;

  protected $cityGraphNodes;
  protected $cityGraph;

  protected $shortestPathFinder;

  public function __construct($mapConfig, $cityNames, $connectionsConfig) {
    $this->mapConfig = $mapConfig;
    $this->cityNames = $cityNames;
    $this->connectionsConfig = $connectionsConfig;

    $this->dbMap = new \Map();
    $this->dbCities = array();
    $this->dbConnections = array();
    $this->cityGraphNodes = array();
  }

  public function performInstall() {
    $this->installMap();
    $this->installCities();
    $this->installConnections();
  }

  protected function installMap() {
    $this->dbMap = new \Map();
    $this->dbMap->setName($this->mapConfig['name']);
    $this->dbMap->save();
  }

  protected function installCities() {
    $i = 0;
    foreach ($this->cityNames AS $cityName) {
      $this->installCity($i, $cityName);
      ++$i;
    }
  }

  protected function installCity($cityConfigId, $cityName) {
    $dbCity = new \City();
    $dbCity->setName($cityName);
    $dbCity->setMap($this->dbMap);
    $dbCity->save();

    $this->dbCities[$cityConfigId] = $dbCity;
  }

  protected function installConnections() {
    $this->buildCityNodes($this->connectionsConfig);
    $this->cityGraph = new \PowerGrid\Structures\CityConnectionsGraph();
    $this->cityGraph->populateFromIncompleteGraphNodes($this->cityGraphNodes);
    $this->installAllShortestPaths();
  }

  protected function installAllShortestPaths() {
    $this->shortestPathFinder = new \PowerGrid\Services\DijkstraShortestPathAlgorithm($this->cityGraph);
    foreach ($this->cityGraph->getNodes() AS $startNode) {
      $this->shortestPathFinder->setStartNode($startNode);
      foreach ($startNode->getNeighbors() AS $endNode) {
        $this->shortestPathFinder->setEndNode($endNode);
        $distance = $this->shortestPathFinder->calculateShortestPath();
        $this->installShortestPath($startNode, $endNode, $distance);
      }
    }
  }

  protected function installShortestPath($fromNode, $toNode, $distance) {
    $connection = new \CityConnection();
    $connection->setFromCity($this->getDBCity($fromNode));
    $connection->setToCity($this->getDBCity($toNode));
    $connection->setMap($this->dbMap);
    $connection->setCost($distance);
    $connection->save();
  }

  protected function getDBCity(\PowerGrid\Structures\GraphNode $cityNode) {
    return $this->dbCities[$cityNode->getId()];
  }

  protected function buildCityNodes($connectionsConfig) {
    foreach ($connectionsConfig AS $connectionConfig) {
      $cityFromConfigId = $connectionConfig['cities'][0];
      $cityToConfigId = $connectionConfig['cities'][1];
      $connectionPrice = $connectionConfig['price'];

      $this->buildConnection($cityFromConfigId, $cityToConfigId, $connectionPrice);
    }
  }

  protected function buildConnection($cityFromId, $cityToId, $connectionPrice) {
    if (!isset($this->cityGraphNodes[$cityFromId])) {
      $this->cityGraphNodes[$cityFromId] = new \PowerGrid\Structures\GraphNode($cityFromId);
    }
    if (!isset($this->cityGraphNodes[$cityToId])) {
      $this->cityGraphNodes[$cityToId] = new \PowerGrid\Structures\GraphNode($cityToId);
    }

    $this->cityGraphNodes[$cityFromId]->addNeighbor($this->cityGraphNodes[$cityToId], $connectionPrice);
  }
}
