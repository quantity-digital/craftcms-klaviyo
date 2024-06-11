<?php

/**
 * Services
 * Services for the Klaviyo module
 * @package Klaviyo
 */

namespace QD\klaviyo\config;

use QD\klaviyo\domains\ConfigService;

trait Services
{
    /**
     * Init components
     *
     * @return void
     */
    private function initComponents(): void
    {
        $this->setComponents([
            'config' => ConfigService::class, //TODO: Move to settings file
        ]);
    }

    public function getConfigService(): ConfigService
    {
        return $this->get('config');
    }
}
