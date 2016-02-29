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

            default : {
                    $this->stderr('Usage: php yii <module-name> on|off');
                    $exit = 100;
                }
        }

        return $exit;
    }

    private function enable($msg)
    {
        if (!isset($msg)) {
            $this->stderr('Usage: php yii <module-name> on msg');
            return 201;
        }
        if (\humanized\maintainable\models\Maintenance::status()) {
            $this->stderr('Maintenance Mode Already Enabled' . \humanized\maintainable\models\Maintenance::current()->comment);
            return 202;
        }
        if (\humanized\maintainable\models\Maintenance::enable($msg)) {
            $this->stdout('Maintenance Mode Enabled');
            return 0;
        }
        $this->stderr('Unhandled Exception');
        return 1;
    }

    private function disable()
    {
        if (\humanized\maintainable\models\Maintenance::status()) {
            $this->stderr('Maintenance Mode Already Disabled');
            return 302;
        }
        if (\humanized\maintainable\models\Maintenance::disable()) {
            $this->stdout('Maintenance Mode Disabled');
            return 0;
        }
        $this->stderr('Unhandled Exception');
        return 1;
    }

}
