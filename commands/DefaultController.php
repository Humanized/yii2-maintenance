<?php

namespace humanized\maintenance\commands;

use humanized\maintenance\models\Maintenance;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DefaultController extends \yii\console\Controller
{

    /**
     * 
     * Yii2 Maintenance Mode CLI
     * 
     * Usage: php yii <module-name> enable|disable|status'
     * 
     * @param string $cmd - enable|disable|status
     * @return int
     */
    public function actionIndex($cmd)
    {
        $success = false;
        switch ($cmd) {
            case 'status': {
                    $this->stdout('Maintenance Mode ' . (Maintenance::isEnabled() ? 'Enabled' : 'Disabled'));

                    break;
                }
            case 'enable' :
            case 'disable': {
                    $success = call_user_func([new Maintenance(), $cmd]);
                    break;
                }

            default : {
                    $this->stdout('Yii2 Maintenance Mode CLI Usage: php yii <module-name> on|off|status');
                    break;
                }
        }
        $this->stdout("\n");
        return 0;
    }

}
