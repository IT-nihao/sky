<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $uid
 * @property string $uname
 * @property string $upwd
 * @property string $email
 * @property string $tel
 * @property string $real_name
 * @property string $id_card
 * @property string $face
 * @property integer $add_time
 * @property string $fr_link
 * @property integer $count
 * @property integer $set_num
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['add_time', 'count', 'set_num'], 'integer'],
            [['uname', 'email', 'tel', 'real_name', 'id_card', 'face', 'fr_link'], 'string', 'max' => 255],
            [['upwd'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'uname' => 'Uname',
            'upwd' => 'Upwd',
            'email' => 'Email',
            'tel' => 'Tel',
            'real_name' => 'Real Name',
            'id_card' => 'Id Card',
            'face' => 'Face',
            'add_time' => 'Add Time',
            'fr_link' => 'Fr Link',
            'count' => 'Count',
            'set_num' => 'Set Num',
        ];
    }
}
