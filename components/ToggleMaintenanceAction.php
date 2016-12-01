<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized
 * @license https://github.com/humanized/yii2-maintenance/LICENSE.md
 */

namespace humanized\maintenance\components;

/**
 * 
 * 
 * @name Yii2 Maintenance Module
 * @version 1.0
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-maintenance
 * 
 */
use Yii;
use yii\base\Action;
use humanized\maintenance\models\Maintenance;

class ToggleMaintenanceAction extends Action
{

    public function run()
    {
        Maintenance::isEnabled() ?
                        Maintenance::disable() :
                        Maintenance::enable();
        return $this->controller->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

}
