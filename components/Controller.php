<?php

namespace humanized\maintainable\components;

use yii\web\Controller as SuperClass;
use humanized\maintainable\models\Maintenance;
use Yii;

/**
 * SearchController wires the various display actions.
 */
class Controller extends SuperClass {

    protected $maintenance = FALSE;
    protected $maintenceRedirect = NULL;

    public function beforeAction($action)
    {
        //return parent call when maintenance is disbled or user has read permission
        if (Maintenance::status() && !\humanized\maintainable\Module::getInstance()->params->canRead) {
            $this->maintenance = TRUE;
            $this->redirect([\humanized\maintainable\Module::getInstance()->id . "/default/index"]);
            
        }
        return parent::beforeAction($action);
    }

}
