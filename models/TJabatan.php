<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_jabatan".
 *
 * @property integer $id
 * @property string $jabatan
 *
 * @property TKaryawan[] $tKaryawans
 */
class TJabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jabatan'], 'required','message'=>'{attribute} tidak boleh kosong'],
            [['id'], 'integer'],
            [['jabatan'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Kode Jabatan',
            'jabatan' => 'Nama Jabatan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKaryawans()
    {
        return $this->hasMany(TKaryawan::className(), ['id_jabatan' => 'id']);
    }
}
