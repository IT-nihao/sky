<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property integer $hid
 * @property string $message
 * @property string $no
 * @property string $type
 * @property string $gold
 * @property integer $addtime
 * @property integer $uid
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addtime', 'uid'], 'integer'],
            [['message', 'type', 'gold'], 'string', 'max' => 255],
            [['no'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hid' => 'Hid',
            'message' => 'Message',
            'no' => 'No',
            'type' => 'Type',
            'gold' => 'Gold',
            'addtime' => 'Addtime',
            'uid' => 'Uid',
        ];
    }
}
