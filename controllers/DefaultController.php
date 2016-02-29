<?php

namespace humanized\maintenance\components;

use yii\web\Controller as SuperClass;
use humanized\maintenance\models\Maintenance;

/**
 * SearchController wires the various display actions.
 */
class DefaultController extends SuperClass {

    public function actionIndex()
    {
        if (Maintenance::status()) {
            return $this->render('index');
        }
        return new \yii\base\InvalidRouteException("Maintenance mode is disabled");
    }

}
