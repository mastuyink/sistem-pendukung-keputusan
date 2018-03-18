<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_tahun".
 *
 * @property integer $id
 * @property string $tahun
 *
 * @property TPenilaian[] $tPenilaians
 */
class TTahun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_tahun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tahun'], 'required'],
            [['id'], 'integer'],
            [['tahun'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tahun' => 'Tahun',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPenilaians()
    {
        return $this->hasMany(TPenilaian::className(), ['id_tahun' => 'id']);
    }

    public static function ambilSemuaTahun(){
        return self::find()->orderBy(['id'=>SORT_ASC])->all();
    }
}
