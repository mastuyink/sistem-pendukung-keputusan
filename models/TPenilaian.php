<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_penilaian".
 *
 * @property integer $id
 * @property integer $id_karyawan
 * @property integer $id_periode_kriteria
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
            [['id_karyawan', 'id_bulan', 'id_tahun'], 'required','message'=>'{attribute} tidak boleh kosong'],
            [['id_karyawan', 'id_periode_kriteria', 'id_bulan', 'id_tahun'], 'integer','message'=>'{attribute} hanya boleh angka'],
            [['create_at', 'update_at','nilai_normalisasi','nilai'], 'safe'],
            [['id_karyawan'], 'exist', 'skipOnError' => true, 'targetClass' => TKaryawan::className(), 'targetAttribute' => ['id_karyawan' => 'id']],
            [['id_bulan'],'in','range'=>array_keys(ModelBulan::ambilSemuaBulan())],
            [['id_tahun'], 'exist', 'skipOnError' => true, 'targetClass' => TTahun::className(), 'targetAttribute' => ['id_tahun' => 'id']],
            [['id_periode_kriteria'], 'exist', 'skipOnError' => true, 'targetClass' => TPeriodeKriteria::className(), 'targetAttribute' => ['id_periode_kriteria' => 'id']],
            //[['nilai'],'integer','min'=>0,'max'=>100,'tooSmall'=>'Nilai Minimal 0','tooBig'=>'Maksimal Nilai 100'],
        
            //[['nilai'], 'nilaiValidator'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_karyawan' => 'Karyawan',
            'id_periode_kriteria' => 'Kritreria',
            'id_bulan' => 'Bulan',
            'id_tahun' => 'Tahun',
            'nilai' => 'Nilai',
            'bobot_saat_ini' => 'Bobot Saat Ini',
            'nilai_normalisasi' => 'Nilai Dinormalisasi',
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
    public function getIdPeriodeKriteria()
    {
        return $this->hasOne(TPeriodeKriteria::className(), ['id' => 'id_periode_kriteria']);
    }

    public static function ambilNamaBulan($bulan){
       return ModelBulan::ambilNamaBulan($bulan);
    }

    public function afterSave ( $insert, $changedAttributes ){
        //mencari nilai tertinggi pada tahun, bulan dan kriteria yang diinputkan
        $nilaiTertinggi = TPenilaian::find()->select('MAX(nilai) AS nilaiMax')
                          ->where(['id_tahun'=>$this->id_tahun])
                          ->andWhere(['id_bulan'=>$this->id_bulan])
                          ->andWhere(['id_periode_kriteria'=>$this->id_periode_kriteria])
                          ->asArray()->one();
        $db = Yii::$app->getDb();

        //memperbaarui nilai normaslisasi jika ada perubahan nilai atau input nilai baru
        $db->createCommand('UPDATE t_penilaian SET nilai_normalisasi = nilai/'.$nilaiTertinggi['nilaiMax'].' WHERE id_periode_kriteria = '.$this->id_periode_kriteria.' AND id_bulan = '.$this->id_bulan.' AND id_tahun = '.$this->id_tahun.' ')->execute();
            return true;
    }

}
