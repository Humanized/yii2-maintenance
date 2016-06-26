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
 * <tr><td>bypassRedirect</td><td>boolean or callable evaluating to a boolean</td></tr>
 * <tr><td>bypassRedirectPermission</td><td>Permission to be evaluated using Yii::$app->user->can()</td></tr>
 * <tr><td>whitelist</td><td>Array of routes which bypass redirection</td></tr>
 * </table>
 * 
 * 
 * 
 *
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
     * @var string the messageCategory used by Yii::t for translation purposes
     */
    public $messageCategory = 'appx';

    /**
     *
     * @var type string  Permission to be evaluated using Yii::$app->user->can()
     */
    public $bypassRedirectPermission = null;

    /**
     *
     * @var boolean|callable 
     */
    public $bypassRedirect = false;

    /**
     *
     * @var boolean  
     */
    public $whitelistLoginUrl = true;

    /**
     *
     * @var boolean
     */
    public $whitelistErrorHandler = true;

    /**
     *
     * @var array 
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
        if ($this->whitelistErrorHandler) {
            $this->whitelist[] = Yii::$app->errorHandler->errorAction;
        }
        if ($this->whitelistLoginUrl) {
            $this->whitelist[] = Yii::$app->user->loginUrl[0];
        }
        if (Maintenance::isEnabled() &&
                (!isset($this->bypassRedirectPermission) ? true : !Yii::$app->user->can($this->bypassRedirectPermission)) &&
                !$this->evalBypassRedirect() && !$this->isWhitelisted()) {
            throw new HttpException(503, Yii::t($this->messageCategory, $this->message));
        }
    }

    /**
     * 
     * @return type
     */
    protected function isWhiteListed()
    {
        return in_array(Yii::$app->controller->getRoute(), $this->whitelist);
    }

    /**
     * 
     */
    protected function evalBypassRedirect()
    {
        $bypass = false;
        if (!$bypass) {
            if (is_bool($this->bypassRedirect)) {
                $bypass = $this->bypassRedirect;
            }
            if (is_callable($this->bypassRedirect)) {
                $bypass = call_user_func($this->bypassRedirect);
            }
        }
        return $bypass;
    }

    /*
      public function redirectAll($event)
      {


      if (\humanized\maintenance\models\Maintenance::status() && (\Yii::$app->user->isGuest || !\Yii::$app->user->can(\common\components\AuthItemHelper::MAINTENANCE_READ))) {
      $exceptions = array_merge(['maintenance/default/index', \Yii::$app->user->loginUrl[0]], $this->exceptions);
      if (!in_array(\Yii::$app->controller->getRoute(), $exceptions)) {

      //Check if Maintenance Read Restrictions Apply
      if (\Yii::$app->user->isGuest || !\Yii::$app->user->can(\common\components\AuthItemHelper::MAINTENANCE_READ)) {
      return \Yii::$app->runAction('/maintenance/default/index');
      }
      }
      }
      }
     * 
     */
}
