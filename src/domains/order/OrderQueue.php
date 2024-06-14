<?php

namespace QD\klaviyo\domains\order;

use Craft;
use QD\klaviyo\queue\CreateOrderEventQueue;
use Throwable;

class OrderQueue
{
  //* Create
  public static function createEvent(string $name, string $email, ?int $orderId, object|array|null $properties = null)
  {
    try {
      Craft::$app->getQueue()->push(new CreateOrderEventQueue(
        [
          'name' => $name,
          'email' => $email,
          'orderId' => $orderId,
          'properties' => $properties,
        ]
      ));
    } catch (Throwable $e) {
    }
  }
}
