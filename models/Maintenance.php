<?php

namespace humanized\maintainable\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "maintenance".
 *
 * @property integer $id
 * @property integer $time_enabled
 * @property integer $time_disabled
 * @property string $comment
 */
class Maintenance extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maintenance';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'time_enabled',
                'updatedAtAttribute' => 'time_disabled',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time_enabled'], 'required'],
            [['time_enabled', 'time_disabled'], 'integer'],
            [['comment'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time_enabled' => Yii::t('app', 'Time Enabled'),
            'time_disabled' => Yii::t('app', 'Time Disabled'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    public static function status()
    {
        return isset(self::current());
    }

    public static function enable($msg)
    {
        if (!self::status()) {
            $model = new Maintenance(['comment' => $msg]);
            $model->time_disabled = NULL;
            return $model->save();
        }
        return false;
    }

    public static function disable()
    {
        if (self::status()) {
            $models = self::findAll(['IS', 'time_disabled', NULL]);
            foreach ($models as $model) {
                $model->touch('time_disabled');
            }
            return true;
        }
        return false;
    }

    public static function current()
    {
        if (self::status()) {
            return self::findOne(['IS', 'time_disabled', NULL]);
        }
        return NULL;
    }
    
    

}
