<?php

namespace QD\klaviyo\domains\cart;

use Craft;
use craft\commerce\elements\Order;
use craft\commerce\Plugin as Commerce;
use yii\web\HttpException;

class CartService
{
  public static function restore(string $number)
  {
    // Get Order by number
    $order = Order::find()->number($number)->one();

    // If no order, return 404
    if (!$order) {
      throw new HttpException(404);
    }

    // Forget current cart
    Commerce::getInstance()->getCarts()->forgetCart();

    // Restore cart on session
    $session = Craft::$app->getSession();
    $session->set('commerce_cart', $order->number);

    // Return number
    return $order->number;
  }

  public static function getRestoreUrl(string $number)
  {
    $siteUrl = Craft::$app->getSites()->getCurrentSite()->getBaseUrl();
    return $siteUrl . 'api/klaviyo/cart/restore?number=' . $number;
  }
}
