<?php

namespace PowerGrid\Administrative;

class MaxPlayersAlreadyInGame extends \PowerGrid\Exceptions\Administrative {
  protected $defaultMessage = 'The maximum number of players in this game has been reached.';

  public function __construct($maxPlayers) {
    $instanceMessage = $this->defaultMessage;
    if (is_numeric($maxPlayers)) {
      $instanceMessage = "This game already has the maximum number of players ($maxPlayers) in it.";
    }
    parent::__construct($instanceMessage);
  }
}
