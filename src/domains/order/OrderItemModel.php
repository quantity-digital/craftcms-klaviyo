<?php

namespace QD\klaviyo\domains\order;

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

  public static function fromLineItem($item, $purchasable)
  {
    return new self(
      id: $purchasable->id ?? 0,
      sku: $purchasable->sku ?? '',
      title: $purchasable->product->title ?? '',
      variant: $purchasable->title ?? '',
      description: $item->description ?? '',
      url: $purchasable->url ?? '',

      qty: $item->qty ?? 0,
      price: $item->subtotal ?? 0,
      salePrice: $item->total ?? 0,

      unitPrice: $item->price ?? 0,
      unitSalePrice: $item->salePrice ?? 0,

      image: $purchasable->image ?? '', //TODO: Get field from plugin settings + Transform
    );
  }
}
