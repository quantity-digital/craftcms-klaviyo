<?php

namespace QD\klaviyo\queue;

use craft\queue\BaseJob;
use QD\klaviyo\domains\profiles\ProfilesRepository;

class UpdateProfileQueue extends BaseJob
{
    public $id = null;
    public $email = null;
    public $attributes;

    public function execute($queue): void
    {
        if ($this->id) {
            ProfilesRepository::updateFromId($this->id, $this->attributes);
            return;
        }

        if ($this->email) {
            ProfilesRepository::updateFromEmail($this->email, $this->attributes);
            return;
        }
    }

    protected function defaultDescription(): string
    {
        return "Klaviyo: Updating profile";
    }
}
