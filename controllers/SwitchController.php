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

}
