<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized BV Comm V
 * @license https://github.com/humanized/yii2-maintenance/LICENSE
 */

namespace humanized\maintenance\commands;

use humanized\maintenance\models\Maintenance;

/**
 * 
 * Maintenance mode can be managed through command-line interface
 * 
 * When applying the behavior to multiple targets, it may be desirable to specify  
 * 
 * 
 * @name Yii2 Maintenance Module CLI
 * @version 0.1
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-maintenance
 * 
 */
class DefaultController extends \yii\console\Controller
{

    public $alias = null;
    public $path = null;

    public function options()
    {
        return ['alias', 'path'];
    }

    public function optionAliases()
    {
        return ['a' => 'alias', 'p' => 'path'];
    }

    /**
     * 
     * Usage: php yii <module-name> enable|disable|status -a=<path-alias> (optional) -p=<path> (optional)'
     * 
     * @param string $cmd - enable|disable|status
     * @return int
     */
    public function actionIndex($cmd)
    {
        if (isset($this->alias) && isset($this->path)) {
            $this->stderr("Cannot set both alias and path options \n");
            return 1;
        }
        $this->_setupPath();
        $this->_runCmd($cmd);
        $this->stdout("\n");
        return 0;
    }

    private function _setupPath()
    {
        if (isset($this->alias)) {
            Yii::setAlias('@maintenance', Yii::getAlias($this->alias));
        }
        if (isset($this->path)) {
            Yii::setAlias('@maintenance', $this->path);
        }
    }

    private function _runCmd($cmd)
    {
        $success = null;
        switch ($cmd) {
            case 'status': {
                    $this->_status();
                    break;
                }
            case 'enable' :
            case 'disable': {
                    $success = call_user_func([new Maintenance(), $cmd]);
                    $this->_status();
                    break;
                }

            default : {
                    $this->stdout('Yii2 Maintenance Mode CLI Usage: php yii <module-name> enable|disable|status');
                    break;
                }
        }
    }

    private function _status()
    {
        $this->stdout('Maintenance Mode ' . (Maintenance::isEnabled() ? 'Enabled' : 'Disabled'));
    }

}
