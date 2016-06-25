<?php

namespace humanized\maintenance\controllers;

use humanized\maintenance\models\Maintenance;
use yii\web\Controller;
use Yii;

/**
 * Controller for maintenance-mode switch.
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 */
class SwitchController extends Controller
{

    public function actionEnable()
    {
        Maintenance::enable();
        exit;
    }

    public function actionDisable()
    {
        Maintenance::disable();
        exit;
    }

    /**
     * 
     * 
     * @return \yii\base\InvalidRouteException|\yii\web\HttpException
     * @see http://www.checkupdown.com/status/E503.html HTTP Error 503 - Service Unavailable
     */
    /*
      public function actionIndex()
      {
      return new \yii\web\HttpException(Maintenance::status() ? 404 : 503, (Maintenance::status() ? 'The requested page does not exist' : Maintenance::current()->message));
      }

      public function actionEnable()
      {
      if (Yii::$app->controller->module->params['canWrite'] && Maintenance::status()) {
      $msg = Yii::$app->request->post('msg');
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
     * 
     */
}
