<?php

class UserIsNotGameOwner extends \PowerGrid\Exceptions\Administrative {
  protected $defaultMessage = 'User is not the game owner';
}
