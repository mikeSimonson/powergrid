<?php

namespace HTTPPowerGrid\Services;

class UserServices {
  static public function getUserByToken($tokenString) {
    $q = UserTokenQuery::create();
    $userToken = $q->findOneByTokenString($tokenString);
    $user = $userToken->getTokenUser();

    return $user;
  }
}
