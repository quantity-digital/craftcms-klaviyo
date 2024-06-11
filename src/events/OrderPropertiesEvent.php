<?php

namespace QD\klaviyo\events;

use craft\commerce\elements\Order;
use yii\base\Event;

class OrderPropertiesEvent extends Event
{
  public array $properties;
  public Order $order;
}
