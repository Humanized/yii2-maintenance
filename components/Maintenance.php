<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace humanized\maintenance\components;

class Maintenance extends \yii\base\Behavior
{

    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_REQUEST => 'redirectAll'
        ];
    }

    public function redirectAll($event)
    {

        \yii\helpers\VarDumper::dump(get_class($event->sender));
        //Get the current route
        // echo \Yii::$app->urlManager->parseUrl(\Yii::$app->request);
        if (\humanized\maintenance\models\Maintenance::status()) {
            //Check if Maintenance Read Restrictions Apply
            if (\Yii::$app->user->isGuest || !\Yii::$app->user->isGuest->can(\common\components\AuthItemHelper::MAINTENANCE_READ)) {
                //Only allow access to login page
                //Catch all other requests (not functioning properly)
                \Yii::$app->catchAll = ['/maintenance/default/index'];
                //   return \Yii::$app->runAction('site/contact');
            }
        }
    }

}
