<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized 
 * @license https://github.com/humanized/yii2-maintenance/LICENSE
 */

namespace humanized\maintenance;

/**
 * Humanized Maintenance for Yii2
 * 
 * Provides several routines and interfaces dealing with a file-based maintenance mode.
 * 
 * Maintenance mode can be toggled through CLI or through GUI by incorporating the provided widget.
 * 
 * @name Yii2 Maintenance Module
 * @version 1.0
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-maintenance
 * 
 */
class Module extends \yii\base\Module
{

    public function init()
    {
        if (\Yii::$app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'humanized\maintenance\commands';
        }
        parent::init();
    }

}
