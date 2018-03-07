<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buy".
 *
 * @property integer $id
 * @property integer $aid
 * @property integer $uid
 * @property integer $start_time
 * @property integer $end_time
 * @property string $start_gold
 * @property integer $is_back
 * @property integer $status
 * @property string $end_gold
 */
class Buy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'buy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'uid', 'start_time', 'end_time', 'is_back', 'status'], 'integer'],
            [['start_gold', 'end_gold'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'uid' => 'Uid',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'start_gold' => 'Start Gold',
            'is_back' => 'Is Back',
            'status' => 'Status',
            'end_gold' => 'End Gold',
        ];
    }
}
