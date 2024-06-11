<?php

namespace QD\klaviyo\domains\order;

use craft\commerce\elements\Order;

class OrderModel
{
  public readonly bool $hasCoupon;
  public readonly bool $hasDiscount;

  public function __construct(
    public readonly int $id,
    public readonly string $number,
    public readonly string $reference,

    public readonly int $total,
    public readonly int $discount,
    public readonly int $shipping,

    public readonly string $currency,
    public readonly int $qty,
    public readonly string $coupon,

    public readonly array $items,
    public readonly array $itemIds,
    public readonly array $itemTitles,
    public readonly array $itemSkus,

    public readonly OrderAddressModel $billingAddress,
    public readonly OrderAddressModel $shippingAddress,

    public readonly string $restoreUrl,
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

      total: $order->totalPrice ?? 0,
      discount: $order->totalDiscount ?? 0,
      shipping: $order->totalShippingCost ?? 0,

      currency: $order->currency ?? '',
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
