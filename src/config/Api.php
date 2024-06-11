<?php

namespace QD\klaviyo\config;

use KlaviyoAPI\KlaviyoAPI;
use QD\klaviyo\Klaviyo;

class Api
{
  public function __construct()
  {
  }

  public static function instance(int $retries = 3, int $wait = 3)
  {
    return new KlaviyoAPI(
      Klaviyo::getInstance()->getConfigService()->getApiKey(), // TODO: Update to settings
      $retries,
      $wait,
    );
  }
}
