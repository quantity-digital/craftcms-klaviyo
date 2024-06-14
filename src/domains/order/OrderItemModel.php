<?php

namespace QD\klaviyo\domains\order;

use craft\commerce\elements\Order;
use craft\commerce\helpers\Currency;

class OrderItemModel
{
  public function __construct(
    public readonly int $id,
    public readonly string $sku,
    public readonly string $title,
    public readonly string $variant,
    public readonly string $description,
    public readonly string $url,

    public readonly int $qty,

    public readonly int $price,
    public readonly int $salePrice,

    public readonly int $unitPrice,
    public readonly int $unitSalePrice,

    public readonly string $image,
  ) {
  }

  public static function fromLineItem($item, $purchasable, Order $order, $image): OrderItemModel
  {
    return new self(
      id: $purchasable->id ?? 0,
      sku: $purchasable->sku ?? '',
      title: $purchasable->product->title ?? '',
      variant: $purchasable->title ?? '',
      description: $item->description ?? '',
      url: $purchasable->url ?? '',

      qty: $item->qty ?? 0,
      price: Currency::formatAsCurrency($item->subtotal, $order->paymentCurrency, true, false) ?? 0,
      salePrice: Currency::formatAsCurrency($item->total, $order->paymentCurrency, true, false) ?? 0,

      unitPrice: Currency::formatAsCurrency($item->price, $order->paymentCurrency, true, false) ?? 0,
      unitSalePrice: Currency::formatAsCurrency($item->salePrice, $order->paymentCurrency, true, false) ?? 0,

      image: (string) $image ?? ''
    );
  }
}
