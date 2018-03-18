<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TPenilaian;

/**
 * TPenilaianSearch represents the model behind the search form about `app\models\TPenilaian`.
 */
class TPenilaianSearch extends TPenilaian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_karyawan', 'id_kriteria', 'id_bulan', 'id_tahun', 'bobot_saat_ini'], 'integer'],
            [['nilai'], 'number'],
            [['create_at', 'update_at'], 'safe'],
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
        $query = TPenilaian::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=> [
                    'id_tahun'    => SORT_DESC,
                    'id_bulan'    => SORT_ASC,
                    'id_karyawan' => SORT_ASC,
                    'id_kriteria' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_karyawan' => $this->id_karyawan,
            'id_kriteria' => $this->id_kriteria,
            'id_bulan' => $this->id_bulan,
            'id_tahun' => $this->id_tahun,
            'nilai' => $this->nilai,
            'bobot_saat_ini' => $this->bobot_saat_ini,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);

        return $dataProvider;
    }
}