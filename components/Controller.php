<?php

namespace humanized\maintainable\components;

use yii\web\Controller as SuperClass;
use humanized\maintainable\models\Maintenance;
use Yii;

/**
 * SearchController wires the various display actions.
 */
class Controller extends SuperClass {

    public function beforeAction($action)
    {
        //return parent call when maintenance is disbled or user has read permission
        if (!Maintenance::status()) {
            return parent::beforeAction($action);
        }
    }

    public function actionMaintenanceModeOn()
    {
        
    }

    public function actionMaintenanceModeOff()
    {
        
    }

}
