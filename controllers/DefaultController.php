<?php

namespace humanized\maintenance\controllers;

use humanized\maintenance\models\Maintenance;
use yii\web\Controller;
use Yii;

/**
 * DefaultController for Maintenance Mode.
 */
class DefaultController extends Controller {

    public function actionIndex()
    {
        if (Maintenance::status()) {
            return $this->render('index');
        }
        return new \yii\base\InvalidRouteException("Maintenance mode is disabled");
    }

    public function actionEnable()
    {
        if (Yii::$app->controller->module->params['canWrite'] && Maintenance::status()) {
            $msg = Yii::$app->request->post('comment');
            if (isset($msg)) {
                Maintenance::enable($msg);
                return $this->goBack();
            }
        }
    }

    public function actionDisable()
    {
        if (Yii::$app->controller->module->params['canWrite'] && !Maintenance::status() && Yii::$app->request->isPost) {
            Maintenance::disable();
            return $this->goBack();
        }
    }

}
