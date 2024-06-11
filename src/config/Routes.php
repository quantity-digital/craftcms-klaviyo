<?php

namespace QD\klaviyo\config;

use craft\events\RegisterUrlRulesEvent;
use craft\web\UrlManager;
use yii\base\Event;

trait Routes
{

  private function registerApiEndpoints()
  {
    Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_SITE_URL_RULES, function (RegisterUrlRulesEvent $event) {
      $event->rules['klaviyo/api/v1/subscribe'] = 'quantity-klaviyo/api/subscribe';
      $event->rules['klaviyo/api/v1/track-event'] = 'quantity-klaviyo/api/track-event';
      $event->rules['klaviyo/api/v1/track-order'] = 'quantity-klaviyo/api/track-order';
    });
  }
}
