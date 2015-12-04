<?php

use Symfony\Component\HttpFoundation\Response as HTTPResponse;
use Propel\Runtime\ActiveQuery\Criteria;

$app->group('/admin', function() use ($app, $json_result) {

  $app->get('/users', function() use ($app, $json_result) {
    $token = $app->request->params('token');
    $adminUser = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $users = \UserQuery::create()->find();
    $usersInfo = array();

    foreach ($users AS $user) {
      if ($user->getId() !== $adminUser->getId()) {
        $availableUserInfo = array();
        $availableUserInfo['id'] = $user->getId();
        $availableUserInfo['name'] = $user->getName();
        $availableUserInfo['username'] = $user->getUsername();
        $availableUserInfo['email'] = $user->getEmail();
        $usersInfo[] = $availableUserInfo;
      }
    }

    $json_result->addData('users', $usersInfo);
    $json_result->setSuccess('User info in data attribute.');
    $app->response->setStatus(HTTPResponse::HTTP_OK);
    $app->response->setBody($json_result->getJSON());
  });

  $app->get('/users/last', function() use ($app, $json_result) {
    $token = $app->request->params('token');
    $adminUser = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $user = \UserQuery::create()->orderBy('id', Criteria::DESC)->limit(1)->find()[0];
    if (is_null($user) || $user->getId() === $adminUser->getId()) {
      $json_result->addError('User not found.');
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
    else {
      $availableUserInfo = array();
      $availableUserInfo['id'] = $user->getId();
      $availableUserInfo['name'] = $user->getName();
      $availableUserInfo['username'] = $user->getUsername();
      $availableUserInfo['email'] = $user->getEmail();
      $json_result->addData('user', $availableUserInfo);
      $json_result->setSuccess('User info in data attribute.');
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }

    $app->response->setBody($json_result->getJSON());
  });

  $app->get('/users/:userId', function($userId) use ($app, $json_result) {
    $token = $app->request->params('token');
    $adminUser = \HTTPPowerGrid\Services\UserServices::getUserByToken($token);

    $userId = intval($userId);
    $user = \UserQuery::create()->findPK($userId);

    if (is_null($user) || $user->getId() === $adminUser->getId()) {
      $json_result->addError('User not found.');
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
    }
    else {
      $availableUserInfo = array();
      $availableUserInfo['id'] = $user->getId();
      $availableUserInfo['name'] = $user->getName();
      $availableUserInfo['username'] = $user->getUsername();
      $availableUserInfo['email'] = $user->getEmail();
      $json_result->addData('user', $availableUserInfo);
      $json_result->setSuccess('User info in data attribute.');
      $app->response->setStatus(HTTPResponse::HTTP_OK);
    }

    $app->response->setBody($json_result->getJSON());
  });

});
