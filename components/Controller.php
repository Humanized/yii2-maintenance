<?php

namespace humanized\maintenance\components;

use yii\web\Controller as YiiController;
use humanized\maintenance\models\Maintenance;

/**
 * SearchController wires the various display actions.
 */
class Controller extends YiiController {

    protected $maintenanceModuleName = 'maintenance';

    public function beforeAction($action)
    {
        //Get Module Parameters through protected maintenanceModuleName variable
        // get the module to which the currently requested controller belongs
        $module = \Yii::$app->getModule($this->maintenanceModuleName);

        //return parent call when maintenance is disbled or user has read permission
        //Get Maintenance Read Permission
        if (Maintenance::status() && !$module->params['canRead']) {
            $this->redirect(["/" . $this->maintenanceModuleName]);
        }
        return parent::beforeAction($action);
    }

}
