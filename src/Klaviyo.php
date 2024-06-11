<?php

namespace QD\klaviyo;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use QD\klaviyo\config\Routes;
use QD\klaviyo\config\Events;
use QD\klaviyo\config\Services;
use QD\klaviyo\models\Settings;

class Klaviyo extends Plugin
{
    use Services;
    use Routes;
    use Events;

    public static $plugin;

    public static $commerceInstalled = false;
    public bool $hasCpSettings = true;


    // Init
    public function init()
    {
        parent::init();

        self::$plugin = $this;
        self::$commerceInstalled = Craft::$app->plugins->isPluginEnabled('commerce');

        $this->initComponents();
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

    protected function settingsHtml(): string
    {
        return Craft::$app->getView()->renderTemplate('craftcms-klaviyo/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}
