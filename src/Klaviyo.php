<?php

namespace QD\klaviyo;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use QD\klaviyo\config\Routes;
use QD\klaviyo\config\Events;
use QD\klaviyo\models\Settings;

class Klaviyo extends Plugin
{
    use Routes;
    use Events;

    public static $plugin;
    public $hasCpSettings = true;


    // Init
    public function init(): void
    {
        parent::init();

        self::$plugin = $this;

        $this->initEvents();
        $this->registerApiEndpoints();
    }

    // Info
    public function getPluginName()
    {
        return 'Klaviyo For CraftCMS & Commerce';
    }

    // Settings
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('craftcms-klaviyo/settings', ['settings' => $this->getSettings()]);
    }
}
