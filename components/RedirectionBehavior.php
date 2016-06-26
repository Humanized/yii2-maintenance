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
 * MaintenanceBehavior is triggered by a before action event.
 * When attached, it throws a 503 HTTP error when maintenance mode is enabled.
 * Individual routes can be added to the whitelisted to bypass the behavior.
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
    public $msg = 'Site in Maintenance';

    /**
     *
     * @var type string   
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
                !$this->bypassRedirect() && !$this->isWhitelisted()) {
            throw new HttpException(503, $this->msg);
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
    protected function byPassRedirect()
    {
        $bypass = false;
        if (!$bypass) {
            if (is_bool($this->bypassRedirect)) {
                $bypass = $this->bypassRedirect;
            }
            if (is_callable($this->bypassRedirect)) {
                $bypass = call_user_func($this->bypassRedirect, [Yii::$app->controller->getRoute()]);
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
