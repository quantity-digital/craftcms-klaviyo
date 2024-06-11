<?php

// TODO: Implement on website

// private function _orderSignup(Order $order): void
// {
//     if (!$order->orderNewsletter) {
//         return;
//     }

//     if (!$order->email) {
//         return;
//     }

//     // Generate the Klaviyo attributes object
//     $att = (object)[
//         'email' => $order->email,
//         'first_name' => $order->customer ? $order->customer->firstName : $order->shippingAddress->firstName,
//         'last_name' => $order->customer ? $order->customer->lastName : $order->shippingAddress->lastName,
//     ];

//     // Add user to klayvio list.
//     Klaviyo::getInstance()->getKlaviyoService()->signup($att, App::env('KLAVIYO_LIST_DEFAULT'));
//     return;
// }

// public function viewedProductEvent(Product $product, string $email): void
// {
//     try {
//         $name = Data::EVENT_PRODUCT_VIEWS;
//         $properties = Klaviyo::getInstance()->getFormatService()->formatProductProperties($product, $product->defaultVariant);

//         Craft::$app->getQueue()->push(new CreateEventQueue(
//             [
//                 'name' => $name,
//                 'email' => $email,
//                 'properties' => $properties,
//             ]
//         ));
//     } catch (\Throwable $th) {
//     }
// }