<?php

namespace PowerGrid\Services;

class DeckStarter implements \PowerGrid\Interfaces\Service {
  public function __construct() {
  
  }

  // Need to associate a list of cards, with the game.
  // Need them to be in random order.
  // Upon doing so, we need to give them all an appropriate status.
  // Depending on how many players there are, a certain number of cards get trash status.
  // A certain number of cards (based on a constant) need to be placed in auction status.
}
