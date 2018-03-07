<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "card".
 *
 * @property integer $cid
 * @property integer $number
 * @property integer $uid
 * @property string $user_name
 */
class Card extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'uid'], 'integer'],
            [['user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'number' => 'Number',
            'uid' => 'Uid',
            'user_name' => 'User Name',
        ];
    }
}
