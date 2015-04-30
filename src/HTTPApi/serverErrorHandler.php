<?php

use Symfony\Component\HttpFoundation\Response as HTTPResponse;

function handleUncaughtException($c) {
  return $c['response']->withStatus(HTTPResponse::HTTP_INTERNAL_SERVER_ERROR)
    ->withHeader('Content-Type', 'text/html')
    ->write('Application error.');
}
