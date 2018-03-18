<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_tempat_lahir".
 *
 * @property integer $id
 * @property string $tempat_lahir
 *
 * @property TKaryawan[] $tKaryawans
 */
class TTempatLahir extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_tempat_lahir';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tempat_lahir'], 'required'],
            [['tempat_lahir'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tempat_lahir' => 'Tempat Lahir',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTKaryawans()
    {
        return $this->hasMany(TKaryawan::className(), ['id_tempat_lahir' => 'id']);
    }
}
