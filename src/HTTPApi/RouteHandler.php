<?php

class RouteHandler {
  public function __construct(Callable $handler, $successMessage, $errorMessage, $errorCode) {
    $this->handler = $handler;
  }

  public function __invoke() {
    try {
      $this->handler(func_get_args());
    }
    catch (\PowerGrid\Exceptions\Administrative $e) {
      $json_result->addError($e->getMessage());
      $app->response->setStatus(HTTPResponse::HTTP_BAD_REQUEST);
      $app->response->setBody($json_result->getJSON());

      $this->
    }
    catch {
    }
  }
}
