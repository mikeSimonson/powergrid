<?php

function installAdminUser($username, $password) {
  $email = 'admin@test.com';
  $name = 'administrator';
  $user = new \User();
  $user->setName($name);
  $user->setUsername($username);
  $user->setEmail($email);
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $user->setPassword($hashed_password);
  $user->save();
}

function giveAdminUserAdminGroupAccess($user) {

}
