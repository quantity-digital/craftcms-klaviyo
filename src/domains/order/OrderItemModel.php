<?php

namespace QD\klaviyo\domains\order;

use craft\commerce\elements\Order;
use craft\commerce\helpers\Currency;

class OrderItemModel
{
  public function __construct(
    public int $id,
    public string $sku,
    public string $title,
    public string $variant,
    public string $description,
    public string $url,

    public int $qty,

    public int $price,
    public int $salePrice,

    public int $unitPrice,
    public int $unitSalePrice,

    public string $image,
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
