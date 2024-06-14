<?php

namespace QD\klaviyo\events;

use craft\commerce\models\LineItem;
use yii\base\Event;

class LineItemPropertiesEvent extends Event
{
  public array $properties;

  public LineItem $lineItem;

  public mixed $purchasable;
}
