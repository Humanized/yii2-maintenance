<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized BV Comm V
 * @license https://github.com/humanized/yii2-maintenance/LICENSE.md
 */

namespace humanized\maintenance\models;

use Yii;

/**
 * 
 * Provides code-based interface for dealing with maintenance-mode file handling 
 * 
 * 
 * @name Yii2 Maintenance Model
 * @version 1.0
 * @author Jeffrey Geyssens <jeffrey@humanized.be>
 * @package yii2-maintenance
 * 
 */
class Maintenance extends \yii\base\Model
{

    /**
     * 
     * @return boolean true when maintenance mode is enabled, false when disabled
     */
    public static function isEnabled()
    {
        return file_exists(self::getFilePath());
    }

    /**
     * 
     * @return boolean true when maintenance mode is disabled, false when enabled
     */
    public static function isDisabled()
    {
        return !self::isEnabled();
    }

    public static function enable()
    {
        if (self::isDisabled()) {
            try {
                touch(self::getFilePath());
                return true;
            } catch (Exception $exc) {
                //Do nothing
            }
        }
        return false;
    }

    public static function disable()
    {
        if (self::isEnabled()) {
            try {
                unlink(self::getFilePath());
                return true;
            } catch (Exception $exc) {
                //Do nothing
            }
        }
        return false;
    }

    public static function getFilePath()
    {
        return Yii::getAlias('@maintenance');
    }

}
