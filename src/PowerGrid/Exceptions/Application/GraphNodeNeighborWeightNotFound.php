<?php

namespace PowerGrid\Exceptions\Application;

class GraphNodeNeighborWeightNotFound extends \PowerGrid\Exceptions\Application {
  const MESSAGE_PREFIX = 'No corresponding connection weight found in target node with id ';
  const MESSAGE_POSTFIX = ' for requested neighbor node ';

  public function __construct($targetId, $neighborId) {
    $instanceMessage = self::MESSAGE_PREFIX . $targetId . self::MESSAGE_POSTFIX . $neighborId;
    parent::__construct($instanceMessage);
  }
}
