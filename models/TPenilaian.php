<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_penilaian".
 *
 * @property integer $id
 * @property integer $id_karyawan
 * @property integer $id_kriteria
 * @property integer $id_bulan
 * @property integer $id_tahun
 * @property double $nilai
 * @property integer $bobot_saat_ini
 * @property string $create_at
 * @property string $update_at
 *
 * @property TLogPenilaian[] $tLogPenilaians
 * @property TKaryawan $idKaryawan
 * @property TBulan $idBulan
 * @property TTahun $idTahun
 * @property TStatusNilai $idStatusNilai
 * @property TKriteria $idKritreria
 */
class TPenilaian extends \yii\db\ActiveRecord
{
    public $hasil_akhir;
    public $jumlah_absensi;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_penilaian';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_karyawan', 'id_kriteria', 'id_bulan', 'id_tahun', 'nilai'], 'required'],
            [['id_karyawan', 'id_kriteria', 'id_bulan', 'id_tahun', 'bobot_saat_ini'], 'integer'],
            [['create_at', 'update_at','nilai_normalisasi'], 'safe'],
            [['id_karyawan'], 'exist', 'skipOnError' => true, 'targetClass' => TKaryawan::className(), 'targetAttribute' => ['id_karyawan' => 'id']],
            [['id_bulan'],'in','range'=>array_keys(ModelBulan::ambilSemuaBulan())],
            [['id_tahun'], 'exist', 'skipOnError' => true, 'targetClass' => TTahun::className(), 'targetAttribute' => ['id_tahun' => 'id']],
            [['id_kriteria'], 'exist', 'skipOnError' => true, 'targetClass' => TKriteria::className(), 'targetAttribute' => ['id_kriteria' => 'id']],
            // [['nilai'],'float','min'=>0,'max'=>100,'tooSmall'=>'Nilai Tidak Boleh Lebih Kecil dari 0','tooBig'=>'Nilai Tidak Boleh Melebihi 100'],
            [['bobot_saat_ini'], 'bobotNilaiValidator'],
            [['nilai'], 'nilaiValidator'],
        ];
    }


    public function bobotNilaiValidator($attribute, $params){
        $inputTahunBulan = $this->id_tahun.$this->id_bulan;
        $kriteria = TKriteria::find()->where(['id'=>$this->idKriteria])->andWhere(['<','CONCAT(id_tahun_valid_start,\'\',id_bulan_valid_start)',$inputTahunBulan])->andWhere(['>','CONCAT(id_tahun_valid_end,\'\',id_bulan_valid_end)',$inputTahunBulan])->one();
        if ($kriteria != null) {
            $this->bobot_saat_ini = $kriteria->bobot;
        }else{
            $errorMessage = 'Bobot Nilai Tidak Ditemukan, Silahkan Periksa tanggal valid Bobot Pada Kriteria '.$this->idKriteria->kriteria;
            $this->addError('bobot_saat_ini','Error');
            Yii::$app->session->setFlash('danger', $errorMessage);
            return false;
        }
    }


    public function nilaiValidator($attribute, $params){
        $nilaiDiinput = explode(".", $this->nilai);
        if ($nilaiDiinput[0] > 100) {
             $this->addError('nilai','Nilai Tidak Boleh Melebihi 100');
            //return false;
        }else{
            return true;
        }
       
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_karyawan' => 'Karyawan',
            'id_kriteria' => 'Kritreria',
            'id_bulan' => 'Bulan',
            'id_tahun' => 'Tahun',
            'nilai' => 'Nilai',
            'bobot_saat_ini' => 'Bobot Saat Ini',
            'bobot_saat_ini' => 'Nilai Dinormalisasi',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
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
    public function getIdTahun()
    {
        return $this->hasOne(TTahun::className(), ['id' => 'id_tahun']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKriteria()
    {
        return $this->hasOne(TKriteria::className(), ['id' => 'id_kriteria']);
    }

    public static function ambilNamaBulan($bulan){
       return ModelBulan::ambilNamaBulan($bulan);
    }

    public function afterSave ( $insert, $changedAttributes ){
        //mencari nilai tertinggi pada tahun, bulan dan kriteria yang diinputkan
        $nilaiTertinggi = TPenilaian::find()->select('MAX(nilai) AS nilaiMax')
                          ->where(['id_tahun'=>$this->id_tahun])
                          ->andWhere(['id_bulan'=>$this->id_bulan])
                          ->andWhere(['id_kriteria'=>$this->id_kriteria])
                          ->asArray()->one();
        $db = Yii::$app->getDb();

        //memperbaarui nilai normaslisasi jika ada perubahan nilai atau input nilai baru
        $db->createCommand('UPDATE t_penilaian set nilai_normalisasi = nilai/'.$nilaiTertinggi['nilaiMax'].' WHERE id_kriteria = '.$this->id_kriteria.' AND id_bulan = '.$this->id_bulan.' AND id_tahun = '.$this->id_tahun.' ')->execute();
            return true;
    }

    public static function ambilNilaiTertinggi($id_tahun,$id_bulan){
        return self::find()->joinWith('idKaryawan')
        ->select('t_penilaian.*, MAX(nilai) AS nilaiMax')
        ->where(['id_tahun'=>$id_tahun])
        ->andWhere(['id_bulan'=>$id_bulan])
        ->orderBy(['id_kriteria'=>SORT_ASC])
        ->groupBy(['id_kriteria'])
        ->asArray()
        ->all();
    }

    public static function ambilDataNilai($id,$status){
        return self::find()->where(['id'=>$id])->one();
    }

    public static function ambilNilai($id_karyawan,$id_kriteria,$id_tahun,$id_bulan,$all = false){
        $model = self::find()->joinWith(['idKaryawan','idKriteria','idTahun'])->where(
                [
                    'AND',
                    ['=','id_karyawan',$id_karyawan],
                    ['=','id_kriteria',$id_kriteria],
                    ['=','id_tahun',$id_tahun],
                    ['=','id_bulan',$id_bulan]
                ]
            )->asArray()
            ->orderBy(['id_kriteria'=>SORT_ASC]);
        if ($all == false) {
            $result = $model->one();
        }else{

            $result = $model->all();
        }
        return $result;
    }
}
