<?php

namespace HTTPApi\Middleware;

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

class AdminGroupAuthorization extends \Slim\Middleware {
  protected $json_result;
  protected $user;
  
  public function __construct($json_result) {
    $this->json_result = $json_result;
  }

  public function call() {
    $this->token = $this->app->request->params('token');
    $this->uriRoute = $this->app->request->getResourceUri();

    if ($this->shouldWeContinue()) {
      $this->next->call();
    }
    else {
      $this->json_result->addError('Restricted area.');
      $this->app->response->setStatus(HTTPResponse::HTTP_UNAUTHORIZED);
      $this->app->response->setBody($this->json_result->getJSON());
    }
  }

  protected function isAdminGroup() {
    return preg_match('/^\/admin/i', $this->uriRoute) !== 0 ? TRUE : FALSE;
  }

  protected function userAuthorizedForAdminGroup() {
    $authorizationGroup = \UserGroupAuthorizationQuery::create()
      ->filterByGroupUser($this->user)
      ->filterByGroupName('admin');

    return is_null($authorizationGroup) ? FALSE : TRUE;
  }

  protected function shouldWeContinue() {
    // If the user isn't asking for an admin group, they can bypass any checks.
    $success = TRUE;

    if ($this->isAdminGroup()) {
      // We can safely assume that any admin routes will require a token.
      $this->user = \HTTPPowerGrid\Services\UserServices::getUserByToken($this->token);
      $success = $this->userAuthorizedForAdminGroup() ? TRUE : FALSE;
    }

    return $success;
  }
}
