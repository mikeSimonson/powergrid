<?php

namespace PowerGrid\Exceptions;

class NeighborAlreadyExistsForCityNode extends \PowerGrid\Exceptions\Application {

  const MESSAGE_PREFIX = 'Neighbor with id ';
  const MESSAGE_POSTFIX = ' for node with id ';

  public function __construct($node, $neighbor) {
    $instanceMessage = self::MESSAGE_PREFIX . $neighbor . self::MESSAGE_POSTFIX . $node;
    parent::__construct($instanceMessage);
  }
}
