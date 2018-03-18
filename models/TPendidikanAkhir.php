<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_pendidikan_akhir".
 *
 * @property int $id
 * @property string $pendidikan_akhir
 *
 * @property TKaryawan[] $tKaryawans
 */
class TPendidikanAkhir extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_pendidikan_akhir';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pendidikan_akhir'], 'required'],
            [['pendidikan_akhir'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pendidikan_akhir' => 'Pendidikan Akhir',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKaryawans()
    {
        return $this->hasMany(TKaryawan::className(), ['id_pendidikan_akhir' => 'id']);
    }
}
