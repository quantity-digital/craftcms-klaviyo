<?php

namespace QD\klaviyo\domains\order;

use QD\klaviyo\Klaviyo;

class OrderItemRepository
{

  public static function getFromLineItem($item, $purchasable, $order)
  {
    $imageHandle = Klaviyo::getInstance()->getSettings()->imageFieldHandle;

    if(!$imageHandle){
        return OrderItemModel::fromLineItem($item, $purchasable, $order, '');
    }

    $image = $purchasable->$imageHandle->one() ?? $purchasable->product->$imageHandle->one() ?? null;

    if (!$image) {
        return OrderItemModel::fromLineItem($item, $purchasable, $order, '');
    }

    $imageTransform = Klaviyo::getInstance()->getSettings()->imageFieldTransform;

    if (!$imageTransform) {
        return OrderItemModel::fromLineItem($item, $purchasable, $order, $image->url);
      }

    return OrderItemModel::fromLineItem($item, $purchasable, $order, $image->getUrl($imageTransform));
  }
}
