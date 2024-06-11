<?php

namespace QD\klaviyo\domains\profiles;

use QD\klaviyo\config\Api;
use QD\klaviyo\domains\events\ListsApi;

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
    return $klaviyo->Profiles->createProfile($body);
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
}
