<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_kelurahan".
 *
 * @property int $id
 * @property int $kecamatan_id
 * @property string $nama
 *
 * @property TKaryawan[] $tKaryawans
 * @property TKecamatan $kecamatan
 */
class TKelurahan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kelurahan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kecamatan_id'], 'required'],
            [['id', 'kecamatan_id'], 'integer'],
            [['nama'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['kecamatan_id'], 'exist', 'skipOnError' => true, 'targetClass' => TKecamatan::className(), 'targetAttribute' => ['kecamatan_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kecamatan_id' => 'Kecamatan ID',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKaryawans()
    {
        return $this->hasMany(TKaryawan::className(), ['id_kelurahan' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKecamatan()
    {
        return $this->hasOne(TKecamatan::className(), ['id' => 'kecamatan_id']);
    }

    public static function ambilKelurahan($condition = []){
        $model = self::find();
        if (!empty($condition)) {
            $model = $model->where($condition);    
        }

        $model = $model->orderBy(['nama'=>SORT_ASC])->all();
        return $model;
    }

}
