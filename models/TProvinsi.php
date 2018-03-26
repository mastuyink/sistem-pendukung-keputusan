<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_provinsi".
 *
 * @property int $id
 * @property string $nama
 *
 * @property TKabupaten[] $tKabupatens
 */
class TProvinsi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_provinsi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKabupatens()
    {
        return $this->hasMany(TKabupaten::className(), ['provinsi_id' => 'id']);
    }

    public static function ambilSemuaProvinsi(){
        return self::find()->all();
    }
}
