<?php

namespace QD\klaviyo\domains\events;

use QD\klaviyo\config\Api;

class EventsApi
{
  //* Create
  public static function createEvent(string $name, string $email, array $properties)
  {
    $body = [
      "data" => [
        "type" => "event",
        "attributes" => [
          "properties" => $properties,
          "metric" => [
            "data" => [
              "type" => "metric",
              "attributes" => [
                "name" => $name,
              ]
            ]
          ],
          "profile" => [
            "data" => [
              "type" => "profile",
              "attributes" => [
                "email" => $email,
              ]
            ]
          ]
        ]
      ]
    ];

    $klaviyo = Api::instance();
    return $klaviyo->Events->createEvent($body);
  }
}
