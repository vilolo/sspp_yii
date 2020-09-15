<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_order".
 *
 * @property int $id
 * @property string|null $goods_type
 * @property float|null $price
 * @property int|null $account
 * @property string|null $name
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $ip
 * @property int|null $status
 * @property string|null $remark
 * @property int|null $created_at
 */
class GoodsOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['account', 'status', 'created_at'], 'integer'],
            [['goods_type'], 'string', 'max' => 20],
            [['name', 'mobile', 'ip'], 'string', 'max' => 30],
            [['address', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_type' => 'Goods Type',
            'price' => 'Price',
            'account' => 'Account',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'ip' => 'Ip',
            'status' => 'Status',
            'remark' => 'Remark',
            'created_at' => 'Created At',
        ];
    }

    public function beforeSave($insert)
    {
        $this->created_at = time();
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }
}