<?php

namespace QD\klaviyo\domains\events;

use QD\klaviyo\config\Api;

class EventsApi
{
  //* Create
  public static function createEvent(string $name, string $email, array $properties)
  {
    $body = [
      'data' => [
        'type' => 'event',
        'attributes' => [
          'properties' => $properties,
          'metric' => [
            'name' => $name,
          ],
          'profile' => [
            'email' => $email,
          ],
        ],
      ],
    ];

    $klaviyo = Api::instance();
    return $klaviyo->Events->createEvent($body);
  }
}
