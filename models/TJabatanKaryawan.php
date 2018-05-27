<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_jabatan_karyawan".
 *
 * @property int $id_karyawan
 * @property int $id_jabatan
 * @property string $tanggal_menjabat
 *
 * @property TJabatan $jabatan
 * @property TKaryawan $karyawan
 */
class TJabatanKaryawan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_jabatan_karyawan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jabatan', 'tanggal_menjabat'], 'required','message'=>'{attribute} Tidak Boleh Kosong'],
            [['id_jabatan'], 'integer'],
            [['tanggal_menjabat'], 'safe'],
            [['id_jabatan'], 'exist', 'skipOnError' => true, 'targetClass' => TJabatan::className(), 'targetAttribute' => ['id_jabatan' => 'id']],
            [['id_karyawan'], 'exist', 'skipOnError' => true, 'targetClass' => TKaryawan::className(), 'targetAttribute' => ['id_karyawan' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_karyawan'      => 'Karyawan',
            'id_jabatan'       => 'Jabatan',
            'tanggal_menjabat' => 'Tanggal Menjabat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdJabatan()
    {
        return $this->hasOne(TJabatan::className(), ['id' => 'id_jabatan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKaryawan()
    {
        return $this->hasOne(TKaryawan::className(), ['id' => 'id_karyawan']);
    }
}
