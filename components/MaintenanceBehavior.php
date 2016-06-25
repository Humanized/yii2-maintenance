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
 * MaintenanceBehavior is triggered by a before action event.
 * When attached, it throws a 503 HTTP error when maintenance mode is enabled.
 * Individual routes can be added to the whitelisted to bypass the behavior.
 * 
 * 
 *
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @since 1.0
 */
class MaintenanceBehavior extends \yii\base\Behavior
{

    /**
     *
     * @var type 
     */
    public $msg = 'Site in Maintenance';

    /**
     *
     * @var array whitelisted routes accessible normally during maintenance mode
     * The array keys are controller-names, the values are an array of allowed action-ids 
     *  
     */
    public $whitelist = [];

    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_ACTION => 'run'
        ];
    }

    public function run($event)
    {
        // echo '<br><br><br><br><br><br><br><br><br><br><br>';
        //Login URL is whitelisted by default (when set)
        if (isset(Yii::$app->user->loginUrl) && isset(Yii::$app->user->loginUrl[0])) {
            //  echo Yii::$app->user->loginUrl[0];
            $this->_whitelistRoute(Yii::$app->user->loginUrl[0]);
        }

        if (Maintenance::isEnabled() && !$this->whitelisted()) {
            return new HttpException(503, $this->msg);
        }
    }

    private function _whitelistRoute($route)
    {
        if (substr($route, 0, 1) == '/') {
            $route = substr($route, 1);
        }
        $parts = explode('/', '/' . $route);
        
    }

    /**
     * 
     * @return boolean
     */
    protected function whitelisted()
    {
        $route = \Yii::$app->controller->getRoute();

        return true;
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
