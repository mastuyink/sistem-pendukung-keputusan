<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_kriteria".
 *
 * @property int $id
 * @property string $kriteria
 * @property string $description
 * @property string $created_at
 *
 * @property TPeriodeKriteria[] $tPeriodeKriterias
 */
class TKriteria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_kriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kriteria', 'description'], 'required'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['kriteria'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kriteria' => 'Kriteria',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPeriodeKriterias()
    {
        return $this->hasMany(TPeriodeKriteria::className(), ['id_kriteria' => 'id']);
    }

    public static function ambilSemuaKriteria(){
        return static::find()->orderBy(['kriteria'=>SORT_ASC])->asArray()->all();
    }
}
