<?php

namespace QD\klaviyo\queue;

use craft\queue\BaseJob;
use QD\klaviyo\domains\events\EventsApi;

class CreateEventQueue extends BaseJob
{
    public $name;
    public $email;
    public $properties;

    public function execute($queue): void
    {
        $this->setProgress($queue, 0.1);
        EventsApi::createEvent($this->name, $this->email, $this->properties);
        $this->setProgress($queue, 1);
    }

    protected function defaultDescription(): string
    {
        return "Klaviyo: Creating $this->name event for $this->email";
    }
}
