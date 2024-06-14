<?php

namespace QD\klaviyo\domains\order;

use craft\commerce\models\Address;

class OrderAddressModel
{
  public function __construct(
    public int $id,

    public string $firstName,
    public string $lastName,
    public string $fullName,

    public string $organization,
    public string $organizationId,

    public string $addressLine1,
    public string $addressLine2,
    public string $locality,
    public string $postalCode,
    public string $countryCode,
    public string $state,
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
      organization: $address->businessName ?? '',
      organizationId: $address->businessTaxId ?? '',
      addressLine1: $address->address1 ?? '',
      addressLine2: $address->address2 ?? '',
      locality: $address->city ?? '',
      postalCode: $address->zipCode ?? '',
      countryCode: $address->countryIso ?? '',
      state: $address->stateName ?? ''
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
