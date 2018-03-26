<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_kabupaten".
 *
 * @property int $id
 * @property int $provinsi_id
 * @property string $nama
 *
 * @property TProvinsi $provinsi
 * @property TKecamatan[] $tKecamatans
 */
class TKabupaten extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kabupaten';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinsi_id'], 'required'],
            [['provinsi_id'], 'integer'],
            [['nama'], 'string', 'max' => 100],
            [['provinsi_id'], 'exist', 'skipOnError' => true, 'targetClass' => TProvinsi::className(), 'targetAttribute' => ['provinsi_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provinsi_id' => 'Provinsi ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvinsi()
    {
        return $this->hasOne(TProvinsi::className(), ['id' => 'provinsi_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKecamatans()
    {
        return $this->hasMany(TKecamatan::className(), ['kabupaten_id' => 'id']);
    }

    public static function ambilKabupaten($condition = []){
        $model = self::find();
        if (!empty($condition)) {
            $model = $model->where($condition);    
        }

        $model = $model->orderBy(['nama'=>SORT_ASC])->all();
        return $model;
    }
}
