<?php

namespace QD\klaviyo\domains\order;

use QD\klaviyo\Klaviyo;

class OrderItemRepository
{

  public static function getFromLineItem($item, $purchasable, $order)
  {
    $imageHandle = Klaviyo::getInstance()->getSettings()->imageFieldHandle;
    $imageTransform = Klaviyo::getInstance()->getSettings()->imageFieldTransform;

    $image = $purchasable->$imageHandle->one() ?? $purchasable->product->$imageHandle->one() ?? null;

    if (!$image) {
      $image = '';
    } else {
      $image = $image->getUrl($imageTransform);
    }

    return OrderItemModel::fromLineItem($item, $purchasable, $order, $image);
  }
}
