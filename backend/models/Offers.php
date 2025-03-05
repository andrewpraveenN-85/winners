<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "offers".
 *
 * @property int $package_id
 * @property int $merchant_id
 * @property int $discount
 *
 * @property Merchants $merchant
 * @property Packages $package
 */
class Offers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['package_id', 'merchant_id'], 'required'],
            [['package_id', 'merchant_id', 'discount'], 'integer'],
            [['package_id', 'merchant_id'], 'unique', 'targetAttribute' => ['package_id', 'merchant_id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merchants::class, 'targetAttribute' => ['merchant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'package_id' => 'Package ID',
            'merchant_id' => 'Merchant ID',
            'discount' => 'Discount',
        ];
    }

    /**
     * Gets query for [[Merchant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMerchant()
    {
        return $this->hasOne(Merchants::class, ['id' => 'merchant_id']);
    }

    /**
     * Gets query for [[Package]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPackage()
    {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
    }
}
