<?php

namespace humanized\maintenance\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "maintenance".
 *
 * @property integer $id
 * @property integer $time_enabled
 * @property integer $time_disabled
 * @property string $comment
 */
class Maintenance extends \yii\db\ActiveRecord
{

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
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'time_enabled',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'time_disabled',
                ],
                'value' => function() {
            return date('U'); // unix timestamp 
        },
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
        $models = Maintenance::find()->where(['IS', 'time_disabled', NULL])->all();
        return count($models) == 0 ? FALSE : TRUE;
    }

    public static function enable($msg)
    {
        if (!self::status()) {
            $model = new Maintenance(['comment' => $msg]);
            $model->time_enabled = date('U');
            return $model->save();
        }
        return false;
    }

    public static function disable()
    {
        if (self::status()) {
            $models = Maintenance::find()->where(['IS', 'time_disabled', NULL])->all();
            foreach ($models as $model) {
                $model->touch('time_disabled');
            }
            return true;
        }
        return false;
    }

    public static function current()
    {
        $model = Maintenance::find()->where(['IS', 'time_disabled', NULL])->one();
        return $model;
    }

}
