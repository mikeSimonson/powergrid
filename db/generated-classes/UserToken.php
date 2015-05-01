<?php

use Base\UserToken as BaseUserToken;

/**
 * Skeleton subclass for representing a row from the 'userToken' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class UserToken extends BaseUserToken
{
  const TOKEN_EXPIRY_INTERVAL = 86400; // 1 day

  public function generateNewToken() {
    $secure = FALSE;
    while($secure === FALSE) {
      $random_bytes = openssl_random_pseudo_bytes(16, $secure);
      if ($random_bytes === FALSE) {
        throw new \Exception("Failed generating secure token.");
      }
    }

    $newToken = bin2hex($random_bytes);

    $this->generateNewExpirationDate();

    $this->setTokenString($newToken);
  }

  public function isExpired() {
    $isExpired = TRUE;
    $now = new DateTime();
    $nowTimestamp = $now->getTimestamp();
    $expiryTimestamp = $this->getExpirationDate();

    if ($expiryTimestamp > $nowTimestamp) {
      $isExpired = FALSE;
    }

    return $isExpired;
  }

  public function generateNewExpirationDate() {
    $now = new DateTime();
    $expirationTimestamp = $now->getTimestamp() + static::TOKEN_EXPIRY_INTERVAL;
    $this->setExpirationDate($expirationTimestamp);
  }
}
