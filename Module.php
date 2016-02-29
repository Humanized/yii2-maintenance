<?php

namespace humanized\maintenance;

/**
 * Humanized Maintenance for Yii2
 * 
 * Provides several routines and interfaces dealing with database driven application maintenance mode.
 * 
 * Maintenance mode can be toggled through CLI or through GUI by incorporating the provided widget.
 * 
 * The module is designed to place nicely with the Yii2    
 * 
 * 
 * @name Yii2 Maintenance Module
 * @version 0.1
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-maintenance
 * 
 */
class Module extends \yii\base\Module {

    public $canRead;
    public $readPermission;
    public $canWrite;
    public $writePermission;

    public function init()
    {
        parent::init();

        if (isset($this->canRead)) {
            $this->params['canRead'] = $this->canRead;
        }
        if (isset($this->canWrite)) {
            $this->params['canWrite'] = $this->canWrite;
        }
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'humanized\maintenance\commands';
        } else {

            if (isset($this->writePermission)) {
                $this->params['writePermission'] = $this->writePermission;
                $this->params['canWrite'] = \Yii::$app->user->can($this->writePermission);
            }

            if (isset($this->readPermission)) {
                $this->params['readPermission'] = $this->readPermission;
                $this->params['canRead'] = \Yii::$app->user->can($this->readPermission);
            }
        }
    }

    public function beforeAction($action)
    {

        return parent::beforeAction($action);
    }

}
