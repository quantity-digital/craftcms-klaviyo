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
    try {
      $order = $event->sender;
      $email = $order->email;

      if (!$email) {
        return;
      }

      OrderQueue::createEvent('Order: Completed', $email, $order->id);
    } catch (\Throwable $th) {
    }
  }

  public static function afterSave($event)
  {
    try {
      $order = $event->sender;
      $email = $order->email ?? null;

      if (!$email) {
        return;
      }

      OrderQueue::createEvent('Order: Updated', $email, $order->id);
    } catch (\Throwable $th) {
    }
  }

  public static function onOrderStatusChange($event)
  {
    try {
      $history = $event->orderHistory;
      $order = $history->getOrder();
      $status = $history->getNewStatus()->name ?? 'Order: Status Changed';
      $email = $order->email;

      OrderQueue::createEvent('Order: ' . $status, $email, $order->id);
    } catch (\Throwable $th) {
    }
  }
}
