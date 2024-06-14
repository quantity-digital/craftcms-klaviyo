<?php

namespace QD\klaviyo\models;

use craft\base\Model;

class Settings extends Model
{
  // API
  public $apiKey = '';
  public $publicKey = '';

  // Lists
  public $defaultList = '';

  // Product
  public $imageFieldHandle = 'image';
  public $imageFieldTransform = 'thumbnail';

  // Events
  public $trackOrderUpdate = false;
  public $trackOrderComplete = false;
  public $trackOrderStatus = false;

  // Rules
  public function rules(): array
  {
    return [
      [['apiKey', 'publicKey'], 'required'],
    ];
  }
}
