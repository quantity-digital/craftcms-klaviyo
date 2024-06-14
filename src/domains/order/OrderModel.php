<?php

namespace QD\klaviyo\domains\order;

use craft\commerce\elements\Order;
use craft\commerce\helpers\Currency;

class OrderModel
{
  public bool $hasCoupon;
  public bool $hasDiscount;

  public function __construct(
    public int $id,
    public string $number,
    public string $reference,

    public int $total,
    public int $discount,
    public int $shipping,

    public string $currency,
    public int $qty,
    public string $coupon,

    public array $items,
    public array $itemIds,
    public array $itemTitles,
    public array $itemSkus,

    public OrderAddressModel $billingAddress,
    public OrderAddressModel $shippingAddress,

    public string $restoreUrl,
  ) {
    $this->hasCoupon = (bool) $this->coupon;
    $this->hasDiscount = (bool) $this->discount > 0;
  }

  public static function fromOrder(Order $order, array $items, array $itemIds, array $itemSkus, array $itemTitles, string $restore)
  {
    return new self(
      id: $order->id ?? 0,
      number: $order->number ?? '',
      reference: $order->reference ?? '',

      total: Currency::formatAsCurrency($order->totalPrice, $order->paymentCurrency, true, false) ?? 0,
      discount: Currency::formatAsCurrency($order->totalDiscount, $order->paymentCurrency, true, false) ?? 0,
      shipping: Currency::formatAsCurrency($order->totalShippingCost, $order->paymentCurrency, true, false) ?? 0,

      currency: $order->paymentCurrency ?? '',
      qty: $order->totalQty ?? 0,
      coupon: $order->couponCode ?? '',

      items: $items ?? [],
      itemIds: $itemIds ?? [],
      itemTitles: $itemTitles ?? [],
      itemSkus: $itemSkus ?? [],

      billingAddress: OrderAddressModel::fromAddress($order->billingAddress),
      shippingAddress: OrderAddressModel::fromAddress($order->shippingAddress),

      restoreUrl: $restore ?? '',
    );
  }
}
