<?php

require_once('../bootstrap.php');

$app = new \Slim\Slim();

$app->post('/register', function() {
  $json_result = new \HTTPApi\JSONResult();

  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  $username_min_len = 3;
  $username_max_len = 40;
  $username_pcre_range = '{' . $username_min_len . ',' . $username_max_len . '}';
  $username_match_pattern = '/^\w' . $username_pcre_range . '$/';

  $pwd_special_chars = '!@#$%^&*()';
  $pwd_min_len = 8;
  $pwd_max_len = 40;
  $pwd_pcre_range = '{' . $pwd_min_len . ',' . $pwd_max_len . '}';
  $pwd_match_pattern = '/^[\w' . $pwd_special_chars . ']' . $pwd_pcre_range . '$/i';

  //@todo: make sure username is not already taken

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $json_result->addError('Invalid email address.');
  }
  
  if (!preg_match($username_match_pattern, $username)) {
    $json_result->addError("Invalid username. Must contain only alphanumerics and '_' and be between $username_min_len and $username_max_len chars.");
  }

  if (!preg_match($pwd_match_pattern, $password)) {
    $json_result->addError("Invalid password. Can only contain chars A-Z, a-z, 0-9, and the special chars $pwd_special_chars. Must be between $pwd_min_len and $pwd_max_len chars.");
  }

  if ($json_result->noErrors()) {
    $json_result->setSuccess('Username ' . $username . ' has been created.');
    $json_result->addData('token', 'someunguessablenumber');
    // Do username operation
  }

  $json_result->send();
});

$app->run();

?>
