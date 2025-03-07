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
class Offers extends \yii\db\ActiveRecord {

    public static function tableName() {
        return 'offers';
    }

    public function rules() {
        return [
            [['package_id', 'merchant_id'], 'required'],
            [['package_id', 'merchant_id', 'discount'], 'integer'],
            [['package_id', 'merchant_id'], 'unique', 'targetAttribute' => ['package_id', 'merchant_id']],
            [['package_id'], 'exist', 'skipOnError' => true, 'targetClass' => Packages::class, 'targetAttribute' => ['package_id' => 'id']],
            [['merchant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Merchants::class, 'targetAttribute' => ['merchant_id' => 'id']],
        ];
    }

    public function attributeLabels() {
        return [
            'package_id' => 'Package',
            'merchant_id' => 'Merchant',
            'discount' => 'Discount',
        ];
    }

    public function getMerchant() {
        return $this->hasOne(Merchants::class, ['id' => 'merchant_id']);
    }

    public function getPackage() {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
    }
}
