<?php

namespace PowerGrid\Interfaces;

interface Observer {
  public function notify(\PowerGrid\Structures\Event $event);
}
