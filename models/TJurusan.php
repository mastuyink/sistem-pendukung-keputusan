<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_jurusan".
 *
 * @property int $id
 * @property string $jurusan
 *
 * @property TJurusanKaryawan[] $tJurusanKaryawans
 */
class TJurusan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_jurusan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jurusan'], 'required','message'=>'{attribute} tidak boleh kosong'],
            [['jurusan'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'jurusan' => 'Jurusan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTJurusanKaryawans()
    {
        return $this->hasMany(TJurusanKaryawan::className(), ['id_jurusan' => 'id']);
    }
}
