<?php

namespace QD\klaviyo\config;

use Craft;
use yii\base\Event;
use craft\commerce\elements\Order;
use craft\commerce\services\OrderHistories;
use QD\klaviyo\domains\order\OrderEvents;

trait Events
{
  public function initEvents(): void
  {
    // Get requests
    $request = Craft::$app->getRequest();

    // Register global event listeners
    $this->registerGlobalEventListeners();

    // Register commerce event listeners
    if (Craft::$app->plugins->isPluginEnabled('commerce')) {
      $this->registerCommerceEventListeners();
    }

    // Register frontend event listeners
    if (!$request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
      $this->registerFrontendEventListeners();
    }

    // Register controlpanel event listeners
    if ($request->getIsCpRequest() && !$request->getIsConsoleRequest()) {
      $this->registerCpEventListeners();
    }
  }

  protected function registerGlobalEventListeners(): void
  {
  }

  protected function registerCommerceEventListeners(): void
  {
    // Order complete
    if ($this->settings->trackOrderComplete) {
      Event::on(Order::class, Order::EVENT_AFTER_COMPLETE_ORDER, [OrderEvents::class, 'afterOrderComplete']);
    }

    // Order update
    if ($this->settings->trackOrderUpdate) {
      Event::on(Order::class, Order::EVENT_AFTER_SAVE, [OrderEvents::class, 'afterSave']);
    }

    // Order status change
    if ($this->settings->trackOrderStatus) {
      Event::on(OrderHistories::class, OrderHistories::EVENT_ORDER_STATUS_CHANGE, [OrderEvents::class, 'onOrderStatusChange']);
    }
  }

  protected function registerFrontendEventListeners(): void
  {
  }

  protected function registerCpEventListeners(): void
  {
  }
}
