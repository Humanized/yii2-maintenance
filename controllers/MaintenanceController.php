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
        //Maintenance disabled check
        if (!Maintenance::status()) {
            return parent::beforeAction($action);
        }
        //Else, run permission check
        //Redirect to maintenance page
        
    }

}


