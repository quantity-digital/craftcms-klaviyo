<?php

namespace QD\klaviyo\domains\profiles;

class ProfilesModel
{
  public function __construct(
    public readonly string $id,
  ) {
  }

  public static function fromKlaviyo(mixed $klaviyo): ProfilesModel
  {
    return new ProfilesModel(
      id: $klaviyo->id,
    );
  }
}
