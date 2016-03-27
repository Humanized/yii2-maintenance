<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace humanized\maintenance\components;

class Maintenance extends \yii\base\Behavior
{

    public $exceptions = [];

    public function events()
    {
        return [
            \yii\web\Application::EVENT_BEFORE_ACTION => 'redirectAll'
        ];
    }

    public function redirectAll($event)
    {
        if (\humanized\maintenance\models\Maintenance::status() && (\Yii::$app->user->isGuest || !\Yii::$app->user->can(\common\components\AuthItemHelper::MAINTENANCE_READ))) {
            $exceptions = array_merge(['maintenance/default/index', \Yii::$app->user->loginUrl[0]], $this->exceptions);
            if (!in_array(\Yii::$app->controller->getRoute(), $exceptions)) {

                //Check if Maintenance Read Restrictions Apply
                if (\Yii::$app->user->isGuest || !\Yii::$app->user->can(\common\components\AuthItemHelper::MAINTENANCE_READ)) {
                    return \Yii::$app->runAction('/maintenance/default/index');
                }
            }
        }
    }

}
