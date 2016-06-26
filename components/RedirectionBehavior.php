<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized BV Comm V
 * @license https://github.com/humanized/yii2-maintenance/LICENSE
 */

namespace humanized\maintenance\components;

use humanized\maintenance\models\Maintenance;
use Yii;
use yii\helpers\Html;
use yii\base\Event;
use yii\web\HttpException;

/**
 * RedirectionBehavior is triggered by a before-controller-action event.
 * When attached to a controller, a 503 - Service Unavailable - HTTP exception is thrown when maintenance mode is enabled.
 * 
 * A custom message display can be set using the message parameter
 * The message supports internationalised through specification of the messageCatagory parameter
 * 
 *   
 * The behavior can be bypassed using a variety of configuration options:
 * 
 * <table>
 * <tr><td>bypassRedirection</td><td>boolean or callable evaluating to a boolean</td></tr>
 * <tr><td>bypassPermission</td><td>Permission to be evaluated using Yii::$app->user->can()</td></tr>
 * <tr><td>whitelist</td><td>Array of routes which bypass redirection</td></tr>
 * </table>
 * 
 * 
 * @name Maintenance Module Redirection Behavior
 * @package yii2-maintenance
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @since 1.0
 */
class RedirectionBehavior extends \yii\base\Behavior
{

    /**
     *
     * @var string the message to display when site is in maintenance mode 
     */
    public $message = 'Site in Maintenance';

    /**
     *
     * @var string the message-category used by Yii::t for translation purposes
     */
    public $messageCategory = 'app';

    /**
     *
     * @var type boolean
     */
    public $force = false;

    /**
     *
     * @var type string  Permission to be evaluated using Yii::$app->user->can() - bypasses redirection when evaluating to true
     */
    public $bypassPermission = null;

    /**
     *
     * @var boolean|callable boolean or callback having boolean return value - bypasses redirection when evaluating to true 
     */
    public $bypassRedirection = false;

    /**
     *
     * @var boolean disable redirection for route setup by loginUrl through the Yii::$app->user component
     */
    public $whitelistLoginUrl = true;

    /**
     *
     * @var boolean disable redirection for route setup by errorAction through the Yii::$app->errorHandler component
     */
    public $whitelistErrorHandler = true;

    /**
     *
     * @var array disable redirection for routes
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
     * @param Event $event
     * @return HttpException
     */
    public function run($event)
    {

        //Throw Http Exception 503 Exception if maintenance mode is applicable
        if (Maintenance::isEnabled() && $this->forbidBypass() && !$this->isWhiteListed()) {
            throw new HttpException(503, Yii::t($this->messageCategory, $this->message));
        }
    }

    /**
     * 
     * @return boolean
     */
    protected function isWhiteListed()
    {
        $route = Yii::$app->controller->getRoute();
        if ($this->whitelistErrorHandler && $route == Yii::$app->errorHandler->errorAction) {
            return true;
        }
        if ($this->whitelistLoginUrl && $route == Yii::$app->user->loginUrl[0]) {
            return true;
        }
        return in_array($route, $this->whitelist);
    }

    /**
     * @return boolean
     */
    protected function forbidBypass()
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

}
