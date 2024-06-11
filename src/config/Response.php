<?php

namespace QD\klaviyo\config;

use Exception;

class Response
{
  public static function success(mixed $data): array
  {
    return [
      'success' => true,
      'data' => $data,
      'message' => null,
    ];
  }

  public static function error(Exception|string $error): array
  {
    return [
      'success' => false,
      'data' => null,
      'message' => $error,
    ];
  }
}
