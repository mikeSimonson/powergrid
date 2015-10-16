<?php

namespace PowerGrid\Exceptions\Administrative;

class CardDoesNotExist extends \PowerGrid\Exceptions\Administrative {
  protected $defaultMessage = 'A card by that ID does not exist.';

  public function __construct($cardId) {
    $instanceMessage = $this->defaultMessage;
    if (is_numeric($cardId)) {
      $instanceMessage = "The card $cardId does not exist.";
    }

    parent::__construct($instanceMessage);
  }
}
