<?php

namespace QD\klaviyo\domains\order;

use craft\base\Component;
use craft\commerce\elements\Order;
use craft\commerce\Plugin as Commerce;
use QD\klaviyo\domains\cart\CartService;
use QD\klaviyo\events\LineItemPropertiesEvent;
use QD\klaviyo\events\OrderPropertiesEvent;
use yii\base\Event;

class OrderRepository
{
  public const EVENT_LINE_ITEM_PROPERTIES = 'lineItemPropertiesEvent';
  public const EVENT_ORDER_PROPERTIES = 'orderPropertiesEvent';

  //* Models
  public static function getFromOrder(Order $order)
  {
    // Base
    $items = [];
    $itemIds = [];
    $itemSkus = [];
    $itemTitles = [];

    // Lineitems
    foreach ($order->getLineItems() as $item) {
      $purchasable = $item->getPurchasable();

      if (!$purchasable) {
        continue;
      }

      $items[] = OrderItemModel::fromLineItem($item, $purchasable);
      $itemIds[] = $purchasable->id ?? 0;
      $itemSkus[] = $purchasable->sku ?? '';
      $itemTitles[] = $purchasable->product->title ?? '';
    }

    // Restore
    $restore = CartService::getRestoreUrl($order->number);

    // Return model
    return OrderModel::fromOrder($order, $items, $itemIds, $itemSkus, $itemTitles, $restore);
  }

  public static function getFromOrderNumber(string $number)
  {
    // Get Order by number
    $order = Order::find()->number($number)->one();

    // Return model
    return self::getFromOrder($order);
  }

  public static function getFromOrderId(int $orderId)
  {
    // Get Order by ID
    $order = Order::find()->id($orderId)->one();

    // Return model
    return self::getFromOrder($order);
  }

  public static function getFromActiveCart()
  {
    // Order
    $order = Commerce::getInstance()->getCarts()->getCart();

    // Return model
    return self::getFromOrder($order);
  }


  //* Events
  public static function eventFromOrder(Order $order): object
  {
    // Base
    $items = [];
    $itemIds = [];
    $itemSkus = [];
    $itemTitles = [];

    // Lineitems
    foreach ($order->getLineItems() as $item) {
      $purchasable = $item->getPurchasable();

      if (!$purchasable) {
        continue;
      }

      $itemIds[] = $purchasable->id ?? 0;
      $itemSkus[] = $purchasable->sku ?? '';
      $itemTitles[] = $purchasable->product->title ?? '';

      $itemEvent = new LineItemPropertiesEvent([
        'properties' => (array) OrderItemModel::fromLineItem($item, $purchasable),
        'lineItem' => $item,
        'purchasable' => $purchasable,
      ]);

      Event::trigger(static::class, self::EVENT_LINE_ITEM_PROPERTIES, $itemEvent);
      $items[] = (object) $itemEvent->properties;
    }

    // Restore
    $restore = CartService::getRestoreUrl($order->number);

    $orderEvent = new OrderPropertiesEvent([
      'properties' => (array) OrderModel::fromOrder($order, $items, $itemIds, $itemSkus, $itemTitles, $restore),
      'order' => $order,
    ]);
    Event::trigger(static::class, self::EVENT_ORDER_PROPERTIES, $orderEvent);

    return (object) $orderEvent->properties;
  }

  public static function eventFromOrderNumber(string $number): object
  {
    // Get Order by number
    $order = Order::find()->number($number)->one();

    // Return model
    return self::eventFromOrder($order);
  }

  public static function eventFromOrderId(int $orderId): object
  {
    // Get Order by ID
    $order = Order::find()->id($orderId)->one();

    // Return model
    return self::eventFromOrder($order);
  }

  public static function eventFromActiveCart(): object
  {
    // Order
    $order = Commerce::getInstance()->getCarts()->getCart();

    // Return model
    return self::eventFromOrder($order);
  }
}
