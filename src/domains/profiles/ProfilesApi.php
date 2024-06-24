<?php

namespace QD\klaviyo\domains\profiles;

use QD\klaviyo\config\Api;
use QD\klaviyo\domains\lists\ListsApi;

/*
    Attributes
    email
    phone_number
    first_name
    last_name
    organization
    title
    image
    location
        address1
        address2
        city
        country
        latitude
        longitude
        region
        zip
        timezone
    properties
        points (Custom)
*/

class ProfilesApi
{
  //* Get
  public static function getProfile(string $id)
  {
    $klaviyo = Api::instance();
    return $klaviyo->Profiles->getProfile($id);
  }

  //* Create
  public static function createProfile(mixed $body)
  {
    $klaviyo = Api::instance();

    $profile = $klaviyo->Profiles->createProfile($body);
    return ProfilesModel::fromArray($profile['data']);
  }

  //* Update
  public static function updateProfile(string $id, mixed $body)
  {
    $klaviyo = Api::instance();
    return $klaviyo->Profiles->updateProfile($id, $body);
  }

  //* Relation
  public static function addProfileToList(string $listId, string $profileId)
  {
    return ListsApi::createListRelationships($listId, $profileId, 'profiles', 'profile');
  }

  public static function subscribeProfileToList(string $listId, string $profileId, string $email)
  {
    $klaviyo = Api::instance();

    $body = [
      "data" => [
        "type" => "profile-subscription-bulk-create-job",
        "attributes" => [
          "custom_source" => "CraftCMS",
          "profiles" => [
            "data" => [
              (object)[
                "type" => "profile",
                "id" => $profileId,
                "attributes" => [
                  "email" => $email,
                  "subscriptions" => [
                    "email" => [
                      "marketing" => [
                        "consent" => "SUBSCRIBED"
                      ]
                    ],
                  ]
                ]
              ]
            ]
          ]
        ],
        "relationships" => [
          "list" => [
            "data" => [
              "type" => "list",
              "id" => $listId,
            ]
          ]
        ]
      ]
    ];

    $klaviyo->Profiles->subscribeProfiles($body);
  }
}
