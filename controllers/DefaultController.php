<?php

namespace humanized\maintenance\controllers;

use humanized\maintenance\models\Maintenance;
use yii\web\Controller;
use Yii;
use yii\web\HttpException;

/**
 * 
 */
class DefaultController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * 
     * 
     * @return \yii\web\HttpException
     * @see http://www.checkupdown.com/status/E503.html HTTP Error 503 - Service Unavailable
     */
    public function actionIndex()
    {

        throw new HttpException(503, 'Site in Maintenance');
        // return new HttpException(503, '<br><br><br><br><br><br><br><br><br><br>hello---------------world');
        //return new \yii\web\HttpException(Maintenance::status() ? 404 : 503, (Maintenance::status() ? 'The requested page does not exist' : Maintenance::current()->message));
    }

    /*

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
