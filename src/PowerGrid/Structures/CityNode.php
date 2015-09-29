<?php

namespace PowerGrid\Structures;

class CityNode {
  protected $neighbors;
  protected $id;

  public function __construct($id) {
    $this->id = $id;
  }

  public function getId() {
    return $this->id;
  }

  public function addNeighbor(\PowerGrid\Structures\CityNode $newNeighbor) {
    $this->neighbors[$newNeighbor->getId()] = $newNeighbor;
  }

  public function isNeighbor(\PowerGrid\Structures\CityNode $node) {
    $isNeighbor = FALSE;

    if ($this->neighbors[$node->getId()] instanceof \PowerGrid\Structures\CityNode) {
      $isNeighbor = TRUE;
    }

    return $isNeighbor;
  }
}
