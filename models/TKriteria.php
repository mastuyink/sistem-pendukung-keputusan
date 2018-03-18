<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_kriteria".
 *
 * @property int $id
 * @property string $kriteria
 * @property int $bobot Dalam Persern (%)
 * @property int $id_bulan_valid_start
 * @property int $id_tahun_valid_start
 * @property int $id_bulan_valid_end
 * @property int $id_tahun_valid_end
 * @property string $description deskripsi bobot penilaian
 * @property string $create_at
 * @property string $update_at
 *
 * @property TBulan $bulanValidStart
 * @property TBulan $bulanValidEnd
 * @property TTahun $tahunValidStart
 * @property TTahun $tahunValidEnd
 * @property TPenilaian[] $tPenilaians
 */
class TKriteria extends \yii\db\ActiveRecord
{
    public $total_bobot;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_kriteria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kriteria', 'bobot', 'id_bulan_valid_start', 'id_tahun_valid_start', 'id_bulan_valid_end', 'id_tahun_valid_end', 'description'], 'required'],
            [['id_bulan_valid_start', 'id_tahun_valid_start', 'id_bulan_valid_end', 'id_tahun_valid_end'], 'integer'],
            [['description'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['kriteria'], 'string', 'max' => 25],
            [['id_bulan_valid_start','id_bulan_valid_end'],'in','range'=>array_keys(ModelBulan::ambilSemuaBulan())],

            [['total_bobot'],'number','max'=>100,'tooBig'=>'Total Bobot Seluruh Kriteria Tidak Boleh Melebihi 100 '],
            
            [['id_tahun_valid_start'], 'exist', 'skipOnError' => true, 'targetClass' => TTahun::className(), 'targetAttribute' => ['id_tahun_valid_start' => 'id']],
            [['id_tahun_valid_end'], 'exist', 'skipOnError' => true, 'targetClass' => TTahun::className(), 'targetAttribute' => ['id_tahun_valid_end' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kriteria' => 'Kriteria',
            'bobot' => 'Bobot',
            'id_bulan_valid_start' => 'Bulan Valid Start',
            'id_tahun_valid_start' => 'Tahun Valid Start',
            'id_bulan_valid_end' => 'Bulan Valid End',
            'id_tahun_valid_end' => 'Tahun Valid End',
            'description' => 'Description',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }




    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahunValidStart()
    {
        return $this->hasOne(TTahun::className(), ['id' => 'id_tahun_valid_start']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTahunValidEnd()
    {
        return $this->hasOne(TTahun::className(), ['id' => 'id_tahun_valid_end']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPenilaians()
    {
        return $this->hasMany(TPenilaian::className(), ['id_kriteria' => 'id']);
    }


    //DIY FUNCTION
    public function afterSave ( $insert, $changedAttributes ){
        if (($modelPenilaian = TPenilaian::find()->where(['id_kriteria'=>$this->id])->andWhere(['BETWEEN','CONCAT( id_tahun, "", id_bulan)',$this->id_tahun_valid_start.$this->id_bulan_valid_start,$this->id_tahun_valid_end.$this->id_bulan_valid_end])->all()) !== null) {
            foreach ($modelPenilaian as $key => $value) {
                $value->bobot_saat_ini = $this->bobot;
                $value->save(false);
            }
        }

        return true;
    }

    public static function ambilNamaBulan($bulan){
       return ModelBulan::ambilNamaBulan($bulan);
    }


    public static function ambilSemuaBobot($id = null){
        $query = self::find()->select('SUM(bobot) as jumlah');
        if ($id != null) {
            $query = $query->where(['!=','id',$id]);
        }
        $query = $query->asArray()->one();

        return $query['jumlah'];
    }

    public function ambilSemuaKriteria(){
        return self::find()->asArray()->all();
    }
}
