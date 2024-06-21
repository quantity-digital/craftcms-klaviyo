<?php

namespace QD\klaviyo\domains\lists;

use QD\klaviyo\config\Api;

class ListsApi
{
  public static function createListRelationships(string $listId, string $relationId, string $endpoint, string $type)
  {
    $body = [
      'data' => [[
        'type' => $type,
        'id' => $relationId
      ]]
    ];

    $klaviyo = Api::instance();
    return $klaviyo->Lists->createListRelationships($listId, $endpoint, $body);
  }
}
