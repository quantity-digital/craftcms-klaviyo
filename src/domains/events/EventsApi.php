<?php

namespace QD\klaviyo\domains\events;

use Exception;
use QD\klaviyo\config\Api;

class EventsApi
{
  //* Create
  public static function createEvent(string $name, string $email, array|null $properties = [])
  {
    if(!$properties)
    {
        throw new Exception("No properties are defined", 1);
        die;
    }

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
