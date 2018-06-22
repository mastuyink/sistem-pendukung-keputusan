<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TKaryawan;

/**
 * TKaryawanSearch represents the model behind the search form about `app\models\TKaryawan`.
 */
class TKaryawanSearch extends TKaryawan
{
    public $id_jabatan;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nip', 'id_jk', 'id_tempat_lahir', 'id_bidang', 'id_jabatan', 'id_user'], 'integer'],
            [['nama', 'tanggal_lahir', 'tanggal_kerja', 'no_telp', 'alamat', 'create_at', 'update_at','jenis_karyawan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TKaryawan::find()->joinWith(['idJabatanKaryawan']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_jk'           => $this->id_jk,
            'id_tempat_lahir' => $this->id_tempat_lahir,
            'tanggal_lahir'   => $this->tanggal_lahir,
            'tanggal_kerja'   => $this->tanggal_kerja,
            'id_bidang'       => $this->id_bidang,
            'jenis_karyawan'  => $this->jenis_karyawan,
            'id_jabatan'      => $this->id_jabatan,
            'id_user'         => $this->id_user,
            'create_at'       => $this->create_at,
            'update_at'       => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'no_telp', $this->no_telp])
            ->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'alamat', $this->alamat]);

        return $dataProvider;
    }
}
