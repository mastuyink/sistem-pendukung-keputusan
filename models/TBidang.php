<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_bidang".
 *
 * @property integer $id
 * @property string $bidang
 *
 * @property TKaryawan[] $tKaryawans
 */
class TBidang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_bidang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bidang'], 'required','message'=>'{attribute} tidak boleh kosong'],
            [['bidang'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bidang' => 'Bidang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKaryawans()
    {
        return $this->hasMany(TKaryawan::className(), ['id_bidang' => 'id']);
    }
}
