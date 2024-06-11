<?php

namespace QD\klaviyo\models;

use craft\base\Model;

class Settings extends Model
{
  // API
  public string $apiKey = '';
  public string $publicKey = '';

  // Lists
  public string $defaultList = '';

  // Product
  public string $imageFieldHandle = 'image';
  public string $imageFieldTransform = 'thumbnail';

  // Events
  public bool $trackOrderUpdate = false;
  public bool $trackOrderComplete = false;
  public bool $trackOrderStatus = false;

  // Rules
  public function rules(): array
  {
    return [
      [['apiKey', 'publicKey'], 'required'],
    ];
  }
}
