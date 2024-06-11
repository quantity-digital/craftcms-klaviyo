<?php

namespace QD\klaviyo\domains\events;

use Craft;
use QD\klaviyo\queue\CreateEventQueue;
use Throwable;

class EventsQueue
{
  //* Create
  public static function createEvent(string $name, string $email, object|array $properties)
  {
    try {
      Craft::$app->getQueue()->push(new CreateEventQueue(
        [
          'name' => $name,
          'email' => $email,
          'properties' => $properties,
        ]
      ));
    } catch (Throwable $e) {
    }
  }
}
