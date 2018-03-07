<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property integer $aid
 * @property string $title
 * @property string $lilu
 * @property integer $time
 * @property string $start_gold
 * @property string $img
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lilu', 'start_gold'], 'number'],
            [['time'], 'integer'],
            [['title', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'Aid',
            'title' => 'Title',
            'lilu' => 'Lilu',
            'time' => 'Time',
            'start_gold' => 'Start Gold',
            'img' => 'Img',
        ];
    }
}
