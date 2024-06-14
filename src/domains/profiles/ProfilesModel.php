<?php

namespace QD\klaviyo\domains\profiles;

class ProfilesModel
{
  public function __construct(
    public readonly string $id,
  ) {
  }

  public static function fromArray(mixed $klaviyo): ProfilesModel
  {
    return new ProfilesModel(
      id: $klaviyo['id'] ?? '',
    );
  }

  public static function fromObject(mixed $klaviyo): ProfilesModel
  {
    return new ProfilesModel(
      id: $klaviyo->id ?? '',
    );
  }

  public static function fromEmpty(): ProfilesModel
  {
    return new ProfilesModel(
      id: '',
    );
  }
}
