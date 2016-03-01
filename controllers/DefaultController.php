<?php

namespace humanized\maintenance\controllers;

use humanized\maintenance\models\Maintenance;
use yii\web\Controller;

/**
 * SearchController wires the various display actions.
 */
class DefaultController extends Controller {

    public function actionIndex()
    {
        if (Maintenance::status()) {
            return $this->render('index');
        }
        return new \yii\base\InvalidRouteException("Maintenance mode is disabled");
    }

}
