<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "t_karyawan".
 *
 * @property integer $id
 * @property integer $nip
 * @property string $nama
 * @property integer $id_jk
 * @property integer $id_tempat_lahir
 * @property string $tanggal_lahir
 * @property string $tanggal_kerja
 * @property integer $id_bidang
 * @property integer $id_jabatan
 * @property string $no_telp
 * @property string $alamat
 * @property integer $id_user
 * @property string $create_at
 * @property string $update_at
 *
 * @property TTempatLahir $idTempatLahir
 * @property TBidang $idBidang
 * @property TJabatan $idJabatan
 * @property TJk $idJk
 * @property TPenilaian[] $tPenilaians
 */
class TKaryawan extends \yii\db\ActiveRecord
{
    const LAKI_LAKI = 1;
    const PEREMPUAN = 2;
    public $jurusan;
    public $id_provinsi;
    public $id_kabupaten;
    public $id_kecamatan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_karyawan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nip', 'nama', 'id_jk', 'id_tempat_lahir', 'tanggal_lahir', 'tanggal_kerja', 'id_bidang', 'id_jabatan', 'no_telp', 'alamat','id_pendidikan_akhir','tanggal_menjabat','id_kelurahan'], 'required'],
            [['tanggal_lahir','tanggal_kerja','tanggal_menjabat'],'date', 'format'=>'php:Y-m-d'],
            [['nip', 'id_jk', 'id_tempat_lahir', 'id_bidang', 'id_jabatan', 'id_user','jurusan'], 'integer'],
            [['tanggal_lahir', 'tanggal_kerja', 'create_at', 'update_at','tanggal_menjabat'], 'safe'],
            [['nama'], 'string', 'max' => 50],
            [['no_telp'], 'string', 'max' => 15],
            [['alamat'], 'string', 'max' => 100],
            [['id_jk'],'in','range'=>[self::LAKI_LAKI,self::PEREMPUAN]],
           // [['nip'],'integer','max'=>20],
            [['nip'], 'unique'],
            [['id_user'], 'unique'],
            [['id_tempat_lahir'], 'exist', 'skipOnError' => true, 'targetClass' => TKabupaten::className(), 'targetAttribute' => ['id_tempat_lahir' => 'id']],
            [['id_bidang'], 'exist', 'skipOnError' => true, 'targetClass' => TBidang::className(), 'targetAttribute' => ['id_bidang' => 'id']],
            [['id_jabatan'], 'exist', 'skipOnError' => true, 'targetClass' => TJabatan::className(), 'targetAttribute' => ['id_jabatan' => 'id']],
            [['id_pendidikan_akhir'], 'exist', 'skipOnError' => true, 'targetClass' => TPendidikanAkhir::className(), 'targetAttribute' => ['id_pendidikan_akhir' => 'id']],
            [['id_kelurahan'], 'exist', 'skipOnError' => true, 'targetClass' => TKelurahan::className(), 'targetAttribute' => ['id_kelurahan' => 'id']],
            [['id_provinsi'], 'exist', 'skipOnError' => true, 'targetClass' => TProvinsi::className(), 'targetAttribute' => ['id_provinsi' => 'id']],
            [['id_kabupaten'], 'exist', 'skipOnError' => true, 'targetClass' => TKabupaten::className(), 'targetAttribute' => ['id_kabupaten' => 'id']],
            [['id_kecamatan'], 'exist', 'skipOnError' => true, 'targetClass' => TKecamatan::className(), 'targetAttribute' => ['id_kecamatan' => 'id']],
            //['id_pendidikan_akhir','validasiJurusan'],
            ['jurusan', 'required', 'when' => function ($model) {
            return $model->id_pendidikan_akhir > 3;
            }, 'whenClient' => "function (attribute, value) {
            return $('#form-jurusan-akhir').val() > 3;
            }"]
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                  => 'ID',
            'nip'                 => 'Nip',
            'nama'                => 'Nama',
            'id_jk'               => 'Jenis Kelamin',
            'id_tempat_lahir'     => 'Tempat Lahir',
            'tanggal_lahir'       => 'Tanggal Lahir',
            'tanggal_kerja'       => 'Tanggal Kerja',
            'id_pendidikan_akhir' => 'Pendidikan Akhir',
            'tanggal_menjabat'    => 'Tanggal Menjabat',
            'id_bidang'           => 'Bidang',
            'id_jabatan'          => 'Jabatan',
            'no_telp'             => 'No Telp',
            'jurusan'             => 'Jurusan',
            'alamat'              => 'Alamat',
            'id_user'             => 'User',
            'id_provinsi'         => 'Provinsi',
            'id_kabupaten'        => 'Kabupaten',
            'id_kecamatan'        => 'Kecamatan',
            'id_kelurahan'        => 'Kelurahan',
            'create_at'           => 'Create At',
            'update_at'           => 'Update At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTempatLahir()
    {
        return $this->hasOne(TKabupaten::className(), ['id' => 'id_tempat_lahir']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBidang()
    {
        return $this->hasOne(TBidang::className(), ['id' => 'id_bidang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdJabatan()
    {
        return $this->hasOne(TJabatan::className(), ['id' => 'id_jabatan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPenilaians()
    {
        return $this->hasMany(TPenilaian::className(), ['id_karyawan' => 'id']);
    }

    public function getIdPendidikanAkhir()
    {
        return $this->hasOne(TPendidikanAkhir::className(), ['id' => 'id_pendidikan_akhir']);
    }

    public function getIdJurusanKaryawan()
    {
        return $this->hasOne(TJurusanKaryawan::className(), ['id_karyawan' => 'id']);
    }

    public function getIdKelurahan()
    {
        return $this->hasOne(TKelurahan::className(), ['id' => 'id_kelurahan']);
    }


        public function jenisKelamin($jk)
    {
        if ($jk == 1 ) {
            return "L";
        }elseif ($jk == 2) {
            return "P";
        }else{
            return "Jenis Kelamin Tidak Ditemukan";
        }
    }

    public function ambilSemuaKaryawan(){
        return self::find()->asArray()->all();
    }

    public function afterSave($insert, $changedAttributes)
    {

        if ($this->id_pendidikan_akhir > 3) {
            $data = [
                'id_karyawan' => $this->id,
                'id_jurusan' => $this->jurusan,
            ];
            TJurusanKaryawan::setJurusan($data);
        }
        return true;
    }

    public function validasiJurusan($attribute, $params, $validator){
        if ($this->id_pendidikan_akhir > 2 && $this->jurusan == null) {
            return $this->addError('jurusan','Jurursan Tidak Boleh Kosong');
            // Yii::$app->session->setFlash('danger', 'Salah Bro');
            // return false;
        }else{
                return true;
         }
    }
    
   
}
