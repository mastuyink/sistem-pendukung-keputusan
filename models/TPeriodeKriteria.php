<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_periode_kriteria".
 *
 * @property int $id
 * @property int $id_kriteria
 * @property int $bobot Dalam Persern (%)
 * @property int $id_bulan_valid_start
 * @property int $id_tahun_valid_start
 * @property int $id_bulan_valid_end
 * @property int $id_tahun_valid_end
 * @property string $create_at
 * @property string $update_at
 *
 * @property TPenilaian[] $tPenilaians
 * @property TTahun $tahunValidStart
 * @property TTahun $tahunValidEnd
 * @property TTahun $bulanValidEnd
 * @property TKriteria $kriteria
 */
class TPeriodeKriteria extends \yii\db\ActiveRecord
{
    public $total_bobot;
    public $listKriteria;
    public $periode_kriteria;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 't_periode_kriteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_bulan_valid_start', 'id_tahun_valid_start', 'id_bulan_valid_end', 'id_tahun_valid_end'], 'required','message'=>'{attribute} tidak boleh Kosong'],
            [['id_kriteria', 'id_bulan_valid_start', 'id_tahun_valid_start', 'id_bulan_valid_end', 'id_tahun_valid_end','total_bobot'], 'integer'],
            [['create_at', 'update_at','bobot','listKriteria','periode_kriteria'], 'safe'],
            [['id_tahun_valid_start'], 'exist', 'skipOnError' => true, 'targetClass' => TTahun::className(), 'targetAttribute' => ['id_tahun_valid_start' => 'id']],
            [['id_tahun_valid_end'], 'exist', 'skipOnError' => true, 'targetClass' => TTahun::className(), 'targetAttribute' => ['id_tahun_valid_end' => 'id']],
            [['id_kriteria'], 'exist', 'skipOnError' => true, 'targetClass' => TKriteria::className(), 'targetAttribute' => ['id_kriteria' => 'id']],
            [['id_bulan_valid_start', 'id_tahun_valid_start', 'id_bulan_valid_end', 'id_tahun_valid_end'],'validasiBulanTahun'],
            [['total_bobot'],'integer','min'=>0,'max'=>100,'tooSmall'=>'Total bobot harus lebih dari 0','tooBig'=>'Total Semua Bobot Tidak boleh melebihi 100'],
            // [['bobot'],'required','when'=>function($model){
            //     return $model->listKriteria = true;
            // },'whenClient'=>"function (attribute, value) {
            //     var parentCheckbox = $(this).attr('parent-checkbox');
            //     return $('#'+parentCheckbox).is(':checked');
            // }",'message'=>'{attribute} tidak boleh kosong']

        ];
    }

    // public function validasiTotalBobot($attribute, $params, $validator){

    //     $periodeKriteriaTerInput = TPeriodeKriteria::find()
    //         ->where([
    //             'AND',
    //             ['CONCAT(id_tahun_valid_start,"-",id_bulan_valid_start)'=>$this->id_tahun_valid_start.'-'.$this->id_bulan_valid_start],
    //             ['CONCAT(id_tahun_valid_end,"-",id_bulan_valid_end)'=>$this->id_tahun_valid_end.'-'.$this->id_bulan_valid_end],
    //         ])->sum('bobot');
    //     if ($periodeKriteriaTerInput > 100) {
    //         $this->addError('total_bobot','Total Bobot Todak boleh Melebihi 100, terdeteksi = '.$periodeKriteriaTerInput);
    //         return false;
    //     }else{
    //         return true;
    //     }

    // }

    public function validasiBulanTahun($attribute, $params, $validator){
        $startTahunBulan = $this->id_tahun_valid_start.$this->id_bulan_valid_start;
        $endTahunBulan   = $this->id_tahun_valid_end.$this->id_bulan_valid_end;
        if ($endTahunBulan < $startTahunBulan) {
            $this->addError('id_bulan_valid_end','Valid End Harus Lebih Besar dari Valid Start');
            $this->addError('id_tahun_valid_end','Valid End Harus Lebih Besar dari Valid Start');
            return false;
        }else{
            return true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'id_kriteria'          => 'Kriteria',
            'bobot'                => 'Bobot',
            'id_bulan_valid_start' => 'Bulan',
            'id_tahun_valid_start' => 'Tahun',
            'id_bulan_valid_end'   => 'Bulan',
            'id_tahun_valid_end'   => 'Tahun',
            'create_at'            => 'Create At',
            'update_at'            => 'Update At',
            'listKriteria'            => '  ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPenilaians()
    {
        return $this->hasMany(TPenilaian::className(), ['id_periode_kriteria' => 'id']);
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
    public function getBulanValidEnd()
    {
        return $this->hasOne(TTahun::className(), ['id' => 'id_bulan_valid_end']);
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

    public function validasiPeriode(){
        $startPeriode    = $this->id_tahun_valid_start.'-'.$this->id_bulan_valid_start;
        $endPeriode      = $this->id_tahun_valid_end.'-'.$this->id_bulan_valid_end;
        $kriteriaDiinput = TPeriodeKriteria::find()
            ->where('STR_TO_DATE(:startPeriode, "%Y-%m") BETWEEN STR_TO_DATE(CONCAT(id_tahun_valid_start,"-",id_bulan_valid_start), "%Y-%m") AND STR_TO_DATE(CONCAT(id_tahun_valid_end,"-",id_bulan_valid_end), "%Y-%m")',[':startPeriode'=>$startPeriode])
            ->orWhere('STR_TO_DATE(:endPeriode, "%Y-%m") BETWEEN STR_TO_DATE(CONCAT(id_tahun_valid_start,"-",id_bulan_valid_start), "%Y-%m") AND STR_TO_DATE(CONCAT(id_tahun_valid_end,"-",id_bulan_valid_end), "%Y-%m")',[':endPeriode'=>$endPeriode])->one();
        if ($kriteriaDiinput == NULL) {
            return true;
        }else{
            return false;
        }
    }
}
