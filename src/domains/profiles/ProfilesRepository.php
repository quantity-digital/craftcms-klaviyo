<?php

namespace QD\klaviyo\domains\profiles;

use craft\elements\User;
use craft\helpers\Json;
use GuzzleHttp\Client;
use QD\klaviyo\Klaviyo;

class ProfilesRepository
{
  //* Get
  public static function getFromCraftId(int $id): ProfilesModel
  {
    $user = User::find()->id($id)->one();
    return self::getFromEmail($user->email);
  }

  public static function getFromProfileId(string $id): ProfilesModel
  {
    $profile = ProfilesApi::getProfile($id);
    return ProfilesModel::fromKlaviyo($profile);
  }

  public static function getFromEmail(string $email): ProfilesModel
  {
    $client = new Client();

    $res = $client->request('GET', 'https://a.klaviyo.com/api/profiles', [
      'query' => [
        'filter' => 'equals(email,"' . (string) $email . '")',
      ],
      'headers' => [
        'accept' => 'application/json',
        'content-type' => 'application/json',
        'revision' => '2024-02-15',
        'Authorization' => 'Klaviyo-API-Key ' . Klaviyo::getInstance()->getSettings()->apiKey,
      ]
    ]);

    $content = Json::decode($res->getBody()->getContents());
    $profile = (object) $content['data'][0] ?? null;

    return ProfilesModel::fromKlaviyo($profile);
  }

  //* Create
  public static function createFromAttributes(string $email, ?object $attributes = null, ?object $properties = null): ProfilesModel
  {
    $body = [
      'data' => [
        'type' => 'profile',
        'attributes' => [
          'email' => $email,
        ]
      ]
    ];

    if ($attributes) {
      $body['data']['attributes'] = array_merge($body['data']['attributes'], $attributes);
    }

    if ($properties) {
      $body['data']['properties'] = $properties;
    }

    $profile = ProfilesApi::createProfile($body);
    return ProfilesModel::fromKlaviyo($profile);
  }

  public static function createProfileAndAddToList(string $email, ?string $list = null, ?object $attributes = null, ?object $properties = null): ProfilesModel
  {
    $profile = self::createFromAttributes($email, $attributes, $properties);

    if (!$list) {
      $list = null; // TODO: Get list default
    }

    ProfilesApi::addProfileToList($list, $profile->id);

    return $profile;
  }

  //* Update
  public static function updateFromId($id, $attributes)
  {
    $body = [
      'data' => [
        'type' => 'profile',
        'id' => $id,
        'attributes' => $attributes,
      ]
    ];


    return ProfilesApi::updateProfile($id, $body);
  }

  public static function updateFromEmail($email, $attributes)
  {
    $profile = self::getFromEmail($email);
    return self::updateFromId($profile->id, $attributes);
  }
}
