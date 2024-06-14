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

    $profileData = [];
    $profileData[] = [
      'type' => 'profile',
      'id' => $profileId,
      'attributes' => [
        "email" => $email,
        "subscriptions" => [
          "email" => [
            "marketing" => [
              "consent" => "SUBSCRIBED"
            ]
          ],
        ],
      ]
    ];


    // Body
    $body = [
      'data' => [
        "type" => "profile-subscription-bulk-create-job",
        "attributes" => [
          "custom_source" => "Website",
          "profiles" => [
            "data" => $profileData
          ],
        ],
        'relationships' => (object)[
          'list' => (object)[
            'data' => (object)[
              'type' => 'list',
              'id' => $listId
            ]
          ]
        ]
      ]
    ];


    // $body = [
    //   'data' => [
    //     "type" => "profile-subscription-bulk-create-job",
    //     "attributes" => [
    //       "profiles" => (object)[
    //         "data" => [
    //           (object)[
    //             "type" => "profile",
    //             "id" => $profileId,
    //             'attributes' => (object)[
    //               'email' => $email,
    //               "subscriptions" => [
    //                 "email" => [
    //                   "marketing" => [
    //                     "consent" => "SUBSCRIBED"
    //                   ]
    //                 ],
    //               ],
    //             ]
    //           ]
    //         ],
    //       ],
    //     ],
    //     'relationships' => [
    //       'list' => [
    //         'data' => [
    //           'type' => 'list',
    //           'id' => $listId
    //         ]
    //       ]
    //     ]
    //   ]
    // ];

    return $klaviyo->Profiles->subscribeProfiles($body);
  }
}
