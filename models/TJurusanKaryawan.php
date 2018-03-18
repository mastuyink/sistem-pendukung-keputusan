<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_jurusan_karyawan".
 *
 * @property int $id_karyawan
 * @property int $id_jurusan
 *
 * @property TKaryawan $karyawan
 * @property TJurusan $jurusan
 */
class TJurusanKaryawan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_jurusan_karyawan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_karyawan', 'id_jurusan'], 'required'],
            [['id_karyawan', 'id_jurusan'], 'integer'],
            [['id_karyawan'], 'unique'],
            [['id_karyawan'], 'exist', 'skipOnError' => true, 'targetClass' => TKaryawan::className(), 'targetAttribute' => ['id_karyawan' => 'id']],
            [['id_jurusan'], 'exist', 'skipOnError' => true, 'targetClass' => TJurusan::className(), 'targetAttribute' => ['id_jurusan' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_karyawan' => 'Id Karyawan',
            'id_jurusan' => 'Id Jurusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKaryawan()
    {
        return $this->hasOne(TKaryawan::className(), ['id' => 'id_karyawan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJurusan()
    {
        return $this->hasOne(TJurusan::className(), ['id' => 'id_jurusan']);
    }
}
