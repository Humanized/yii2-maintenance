<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized BV Comm V
 * @license https://github.com/humanized/yii2-maintenance/LICENSE
 */

namespace humanized\maintenance\components;

use humanized\maintenance\models\Maintenance;
use Yii;
use yii\web\HttpException;

/**
 * RedirectionBehavior is triggered by a before-controller-action event.
 * 
 * When attached to a controller, a 503 - Service Unavailable - HTTP exception is thrown when maintenance mode is enabled.
 * 
 * Maintenance mode can be forced by configuration, by setting the force parameter to true
 * 
 * A custom message display can be set using the message parameter
 * The message can be internationalised through use of the messageCatagory parameter
 * 
 * By default, redirection is disabled for routes set through Yii::$app->errorHandler->errorAction and Yii::$app->user->loginUrl[0]
 * This can be enabled by setting the whitelistLoginUrl and whitelistErrorAction to false 
 *   
 * The behavior can be further bypassed using a variety of configuration options:
 * <table>
 * <tr><td><b>bypassRedirection</b></td><td>boolean or callable evaluating to a boolean</td></tr>
 * <tr><td><b>bypassPermission</b></td><td>Permission to be evaluated using Yii::$app->user->can()</td></tr>
 * <tr><td><b>whitelist</b></td><td>Array of routes which bypass redirection</td></tr>
 * </table>
 * 

 * 
 * @name Maintenance Mode Redirection Behavior
 * @package yii2-maintenance
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @version 1.0
 */
class RedirectionBehavior extends \yii\base\Behavior
{

    /**
     *
     * @var string The message to display when site is in maintenance mode 
     */
    public $message = 'Site in Maintenance';

    /**
     *
     * @var string The message-category used by Yii::t for translation purposes
     * @default 'app'
     */
    public $messageCategory = 'app';

    /**
     *
     * @var boolean Force redirection by overriding maintenance-mode status check
     * @default false 
     */
    public $force = false;

    /**
     *
     * @var string  Permission to be evaluated using Yii::$app->user->can() - bypasses redirection when evaluating to true
     * @default null 
     */
    public $bypassPermission = null;

    /**
     *
     * @var boolean|callable Bypass redirection when evaluating to true. A boolean flag or callable
     * @default false 
     */
    public $bypassRedirection = false;

    /**
     *
     * @var boolean disable redirection for route setup by loginUrl through the Yii::$app->user component
     * @default true 
     */
    public $whitelistLoginUrl = true;

    /**
     *
     * @var boolean disable redirection for route setup by errorAction through the Yii::$app->errorHandler component
     * @default true 
     */
    public $whitelistErrorAction = true;

    /**
     *
     * @var array disable redirection for routes
     * @default [] 
     */
    public $whitelist = [];

    /**
     * 
     * @inheritdoc
     */
    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_ACTION => 'run'
        ];
    }

    /**
     * 
     * @param type $event
     * @throws HttpException - Http Exception "#503 - Resource not available" is thrown when redirection is applicable
     */
    public function run($event)
    {
        if ($this->isRedirectionEnabled() && $this->isBypassForbidden() && !$this->isRouteWhitelisted()) {
            throw new HttpException(503, Yii::t($this->messageCategory, $this->message));
        }
    }

    /**
     * 
     * @return boolean unless the force option is set to true, the maintenance-mode status is returned 
     */
    protected function isRedirectionEnabled()
    {
        return !$this->force ? Maintenance::isEnabled() : true;
    }

    /**
     * @return boolean false when a bypass condition is met, true otherwise
     */
    protected function isBypassForbidden()
    {
        //forbid bypass redirection by permission
        if (isset($this->bypassPermission) && !Yii::$app->user->can($this->bypassPermission)) {
            return true;
        }
        //forbid bypass redirection by boolean flag
        if (is_bool($this->bypassRedirection)) {
            return !$this->bypassRedirection;
        }

        //forbid bypass redirection by callback evaluation
        if (is_callable($this->bypassRedirection)) {
            return !call_user_func($this->bypassRedirection);
        }
        return true;
    }

    /**
     * 
     * @return boolean - true when current route is contained in the whitelist array, false otherwise
     */
    protected function isRoutewhiteListed()
    {
        $route = Yii::$app->controller->getRoute();
        if ($this->whitelistErrorAction && $route == Yii::$app->errorHandler->errorAction) {
            return true;
        }
        if ($this->whitelistLoginUrl && $route == Yii::$app->user->loginUrl[0]) {
            return true;
        }
        return in_array($route, $this->whitelist);
    }

}
