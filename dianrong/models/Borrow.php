<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "borrow".
 *
 * @property integer $bid
 * @property integer $type
 * @property string $gold
 * @property string $all_gold
 * @property string $lixi
 * @property string $month_gold
 * @property string $last_month_gold
 * @property integer $add_time
 * @property string $will_month
 * @property integer $ready_month
 * @property integer $uid
 */
class Borrow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'borrow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'add_time', 'ready_month', 'uid'], 'integer'],
            [['gold', 'all_gold', 'lixi', 'month_gold', 'last_month_gold'], 'number'],
            [['will_month'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bid' => 'Bid',
            'type' => 'Type',
            'gold' => 'Gold',
            'all_gold' => 'All Gold',
            'lixi' => 'Lixi',
            'month_gold' => 'Month Gold',
            'last_month_gold' => 'Last Month Gold',
            'add_time' => 'Add Time',
            'will_month' => 'Will Month',
            'ready_month' => 'Ready Month',
            'uid' => 'Uid',
        ];
    }
}
