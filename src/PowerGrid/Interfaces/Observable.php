<?php

namespace PowerGrid\Interfaces;

interface Observable {
  /**
   * Adds an observer that will be notified of events.
   */
  public function subscribe(\PowerGrid\Interfaces\Observer $observer);
}
