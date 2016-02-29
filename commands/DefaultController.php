<?php

namespace humanized\maintenance\commands;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DefaultController extends \yii\console\Controller {

    public function actionIndex($cmd, $msg = NULL)
    {
        $exit = 0;
        switch ($cmd) {
            case 'on': {
                    $exit = $this->enable($msg);
                    break;
                }
            case 'off': {
                    $exit = $this->disable();
                    break;
                }
            case 'status': {
                    $this->stdout('Maintenance Mode ' . (\humanized\maintenance\models\Maintenance::status() ? 'Enabled' : 'Disabled'));
                    $exit = 0;
                    break;
                }

            default : {
                    $this->stderr('Usage: php yii <module-name> on|off');
                    $exit = 100;
                    break;
                }
        }
        $this->stdout("\n");
        return $exit;
    }

    private function enable($msg)
    {

        if (!isset($msg)) {
            $this->stderr('Usage: php yii <module-name> on msg');
            return 201;
        }

        if (\humanized\maintenance\models\Maintenance::status()) {
            $this->stderr('Maintenance Mode Already Enabled');
            return 202;
        }

        if (\humanized\maintenance\models\Maintenance::enable($msg)) {
            $this->stdout('Maintenance Mode Enabled');
            return 0;
        }
        $this->stderr('Unhandled Exception');
        return 1;
    }

    private function disable()
    {
        if (!\humanized\maintenance\models\Maintenance::status()) {
            $this->stderr('Maintenance Mode Already Disabled');
            return 302;
        }
        if (\humanized\maintenance\models\Maintenance::disable()) {
            $this->stdout('Maintenance Mode Disabled');
            return 0;
        }
        $this->stderr('Unhandled Exception');
        return 1;
    }

}
