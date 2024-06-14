<?php

/**
 * Config Service
 * Config service for klaviyo module
 * @package klaviyo
 */

namespace QD\klaviyo\domains;

use craft\base\Component;
use craft\helpers\App;

class ConfigService extends Component
{
    /**
     * Returns Klaviyo API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return App::env('KLAVIYO_APIKEY');
    }

    /**
     * Return Klaviyo public key
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return App::env('KLAVIYO_PUBLIC_KEY');
    }

    /**
     * Returns Klaviyo default list
     *
     * @return string
     */
    public function getDefaultList(): string
    {
        return App::env('KLAVIYO_LIST_DEFAULT');
    }
}
