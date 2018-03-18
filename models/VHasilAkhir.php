<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "v_hasil_akhir".
 *
 * @property int $id_karyawan
 * @property int $id_bulan
 * @property int $id_tahun
 * @property double $TOTAL
 * @property string $create_at
 * @property string $update_at
 */
class VHasilAkhir extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_hasil_akhir';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_karyawan', 'id_bulan', 'id_tahun'], 'required'],
            [['id_karyawan'], 'integer'],
            [['TOTAL'], 'number'],
            [['create_at', 'update_at'], 'safe'],
            [['id_bulan', 'id_tahun'], 'string', 'max' => 4],
            [['id_karyawan'], 'exist', 'skipOnError' => true, 'targetClass' => TKaryawan::className(), 'targetAttribute' => ['id_karyawan' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_karyawan' => 'Karyawan',
            'id_bulan' => 'Bulan',
            'id_tahun' => 'Tahun',
            'TOTAL' => 'Total',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    public function getIdKaryawan()
    {
        return $this->hasOne(TKaryawan::className(), ['id' => 'id_karyawan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTahun()
    {
        return $this->hasOne(TTahun::className(), ['id' => 'id_tahun']);
    }

    public static function ambilNamaBulan($bulan){
       return ModelBulan::ambilNamaBulan($bulan);
    }

    public static function ambilRanking(array $data){
        if(($model = self::find()->where(['id_bulan'=>$data['id_bulan']])->andWhere(['id_tahun'=>$data['id_tahun']])->orderBy(['total'=>SORT_DESC])->all()) !== null){
            foreach ($model as $key => $value) {
                if ($value->id_karyawan == $data['id_karyawan']) {
                    return $key+1;
                }
            }
            return "Ranking Tidak Ditemukan";
        }else{

            return "Data Nilai Kosong ";
            
        }
    }
}
