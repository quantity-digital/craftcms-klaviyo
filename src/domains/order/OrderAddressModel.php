<?php

namespace QD\klaviyo\domains\order;

use craft\elements\Address;

class OrderAddressModel
{
  public function __construct(
    public readonly int $id,

    public readonly string $firstName,
    public readonly string $lastName,
    public readonly string $fullName,

    public readonly string $organization,
    public readonly string $organizationId,

    public readonly string $addressLine1,
    public readonly string $addressLine2,
    public readonly string $locality,
    public readonly string $postalCode,
    public readonly string $countryCode,
    public readonly string $state,
  ) {
  }

  public static function fromAddress(?Address $address)
  {
    if (!$address) {
      return self::fromEmpty();
    }

    return new self(
      id: $address->id ?? 0,
      firstName: $address->firstName ?? '',
      lastName: $address->lastName ?? '',
      fullName: $address->fullName ?? '',
      organization: $address->organization ?? '',
      organizationId: $address->organizationId ?? '',
      addressLine1: $address->addressLine1 ?? '',
      addressLine2: $address->addressLine2 ?? '',
      locality: $address->locality ?? '',
      postalCode: $address->postalCode ?? '',
      countryCode: $address->countryCode ?? '',
      state: $address->state ?? ''
    );
  }

  public static function fromEmpty()
  {
    return new self(
      id: 0,
      firstName: '',
      lastName: '',
      fullName: '',
      organization: '',
      organizationId: '',
      addressLine1: '',
      addressLine2: '',
      locality: '',
      postalCode: '',
      countryCode: '',
      state: ''
    );
  }
}
