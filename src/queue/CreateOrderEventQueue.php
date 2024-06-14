<?php

namespace QD\klaviyo\queue;

use craft\queue\BaseJob;
use QD\klaviyo\domains\order\OrderEvents;

class CreateOrderEventQueue extends BaseJob
{
    public $name;
    public $email;
    public $orderId;
    public $properties;

    public function execute($queue): void
    {
        $this->setProgress($queue, 0.1);
        OrderEvents::createEvent($this->name, $this->email, $this->orderId, $this->properties);
        $this->setProgress($queue, 1);
    }

    protected function defaultDescription(): string
    {
        return "Klaviyo: Creating $this->name event for $this->email";
    }
}
