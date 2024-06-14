<?php

namespace QD\klaviyo\domains\order;

use craft\commerce\helpers\Currency;
use QD\klaviyo\domains\events\EventsApi;
use QD\klaviyo\domains\order\OrderQueue;

class OrderEvents
{
  //* Custom
  public static function createEvent(string $name, string $email, ?int $orderId = null, object|array|null $eventProperties = null)
  {
    if (!$orderId) {
      return;
    }

    // Get order
    $order = OrderRepository::eventFromOrderId($orderId);
    $properties = $eventProperties ? array_merge((array) $order, (array) $eventProperties) : (array) $order;

    // Add event defaults
    if ($order->id) {
      $properties['$unique_id'] = $order->id . '-' . time();
    }

    if ($order->total) {
      $properties['$value'] = Currency::formatAsCurrency($order->total, $order->currency, true, false);
    }

    if ($order->currency) {
      $properties['$currency_code'] = $order->currency;
    }

    EventsApi::createEvent($name, $email, $properties);
  }


  //* Craft Events
  public static function afterOrderComplete($event)
  {
    $order = $event->sender;
    $email = $order->email;

    OrderQueue::createEvent('Placed Order', $email, $order->id);
  }

  public static function afterSave($event)
  {
    $order = $event->sender;
    $email = $order->email;

    OrderQueue::createEvent('Cart Updated', $email, $order->id);
  }

  public static function onOrderStatusChange($event)
  {
    $history = $event->orderHistory;
    $order = $history->getOrder();
    $status = $history->getNewStatus()->name ?? 'Status Changed';
    $email = $order->email;

    OrderQueue::createEvent($status . ' Order', $email, $order->id);
  }
}
