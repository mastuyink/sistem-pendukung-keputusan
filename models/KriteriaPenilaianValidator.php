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
class KriteriaPenilaianValidator extends \yii\base\Model
{
    public $kriteria;
    public $nilai;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['kriteria'],'integer'],
           [['kriteria'],'in','range'=>[1,2]],
           ['nilai', 'required', 'when' => function ($model) {
            return $model->kriteria == 2;
            }, 'whenClient' => "function (attribute, value) {
            return $('#form-jurusan-akhir').val() > 3;
            }",'message'=>'{attribute} tidak boleh kosong'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kriteria' => 'Kriteria',
            'nilai' => 'Nilai',
        ];
    }

}
