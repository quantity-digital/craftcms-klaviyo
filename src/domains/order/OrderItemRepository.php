<?php

namespace QD\klaviyo\domains\order;

use QD\klaviyo\Klaviyo;

class OrderItemRepository
{

  public static function getFromLineItem($item, $purchasable, $order)
  {
    $imageHandle = Klaviyo::getInstance()->getSettings()->imageFieldHandle;

    if (!$imageHandle) {
      return OrderItemModel::fromLineItem($item, $purchasable, $order, '');
    }

    $purchasableImage = $purchasable->$imageHandle ? $purchasable->$imageHandle->one() : null;
    $productImage = $purchasable->product->$imageHandle ? $purchasable->product->$imageHandle->one() : null;

    $image = $purchasableImage ?? $productImage ?? null;

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
