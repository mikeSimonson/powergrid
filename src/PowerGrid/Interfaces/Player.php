<?php

namespace PowerGrid\Interfaces;

interface Player {

  public function getId();
  
  public function getGameId();

  public function notify($action);

}
