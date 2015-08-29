<?php

namespace PowerGrid\Services;

class WalletServices {
  protected $wallet;

  public function __construct(\PowerGrid\Interfaces\WalletData $wallet) {
    $this->wallet = $wallet;
  }

  static public function createWallet() {
    return new \Wallet();
  }
}
