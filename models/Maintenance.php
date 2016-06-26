<?php

namespace humanized\maintenance\models;

use Yii;

class Maintenance extends \yii\base\Model
{

    public static function isEnabled()
    {
        return file_exists(self::getFilePath());
    }

    public static function isDisabled()
    {
        return !self::isEnabled();
    }

    public static function enable()
    {
        if (self::isDisabled()) {
            return touch(self::getFilePath());
        }
        return false;
    }

    public static function disable()
    {
        if (self::isEnabled()) {
            return unlink(self::getFilePath());
        }
        return false;
    }

    public static function getFilePath()
    {
        //     echo Yii::getAlias('@runtime') . '/maintenance' . "\n\n\n";
        return Yii::getAlias('@maintenance');
    }

}
