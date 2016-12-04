<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized
 * @license https://github.com/humanized/yii2-maintenance/LICENSE.md
 */

namespace humanized\maintenance\actions;

/**
 * 
 * Maintenance Mode External Controller Disable Action
 * 
 * 
 * @name Yii2 Maintenance Mode Contoller Disable  Action
 * @version 1.0
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-maintenance
 * 
 */
use Yii;
use yii\base\Action;
use humanized\maintenance\models\Maintenance;

class DisableAction extends Action
{

    public function run()
    {
        $cli = Yii::$app instanceof \yii\console\Application;

        if (!$cli && !Yii::$app->request->isPost) { /* the request method is POST */
            throw \yii\web\MethodNotAllowedHttpException('Method Not Allowed. This url can only handle POST request method');
        }
        Maintenance::isEnabled() ?
                        Maintenance::disable() :
                        null;

        if ($cli) {
            return 0;
        }
        return $this->controller->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }

}
