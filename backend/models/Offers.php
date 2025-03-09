<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "offers".
 *
 * @property int $package_id
 * @property int $merchant_id
 * @property int $discount
 * @property string|null $img
 *
 * @property Merchants $merchant
 * @property Packages $package
 */
class Offers extends \yii\db\ActiveRecord {

    public $image;

    public static function tableName() {
        return 'offers';
    }

    public function rules() {
        return [
            [['package_id', 'merchant_id'], 'required'],
            [['discount', 'image'], 'safe'],
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
            'image' => 'Banner'
        ];
    }

    public function getMerchant() {
        return $this->hasOne(Merchants::class, ['id' => 'merchant_id']);
    }

    public function getPackage() {
        return $this->hasOne(Packages::class, ['id' => 'package_id']);
    }

    public function getImgURL() {
        if ($this->img != null) {
            return Yii::$app->params['back_host'] . 'offers/' . $this->img;
        } else {
            return Yii::$app->params['back_host'] . 'default.jpg';
        }
    }
}
