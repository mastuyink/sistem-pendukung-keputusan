<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_kecamatan".
 *
 * @property int $id
 * @property int $kabupaten_id
 * @property string $nama
 *
 * @property TKabupaten $kabupaten
 * @property TKelurahan[] $tKelurahans
 */
class TKecamatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kecamatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kabupaten_id'], 'required'],
            [['kabupaten_id'], 'integer'],
            [['nama'], 'string', 'max' => 100],
            [['kabupaten_id'], 'exist', 'skipOnError' => true, 'targetClass' => TKabupaten::className(), 'targetAttribute' => ['kabupaten_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kabupaten_id' => 'Kabupaten ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKabupaten()
    {
        return $this->hasOne(TKabupaten::className(), ['id' => 'kabupaten_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKelurahans()
    {
        return $this->hasMany(TKelurahan::className(), ['kecamatan_id' => 'id']);
    }

    public static function ambilKecamatan($condition = []){
        $model = self::find();
        if (!empty($condition)) {
            $model = $model->where($condition);    
        }

        $model = $model->orderBy(['nama'=>SORT_ASC])->all();
        return $model;
    }
}
