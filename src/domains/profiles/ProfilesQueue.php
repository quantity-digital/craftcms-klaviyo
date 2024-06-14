<?php

namespace QD\klaviyo\domains\profiles;

use Craft;
use QD\klaviyo\queue\UpdateProfileQueue;
use Throwable;

class ProfilesQueue
{
  //* Update
  public static function updateProfile(?string $id = null, ?string $email = null, object|array $attributes = [])
  {
    try {
      Craft::$app->getQueue()->push(new UpdateProfileQueue(
        [
          'id' => $id,
          'email' => $email,
          'attributes' => $attributes,
        ]
      ));
    } catch (Throwable $e) {
      echo '<pre>';
      print_r($e->getMessage());
      echo '</pre>';
      die;
    }
  }
}
