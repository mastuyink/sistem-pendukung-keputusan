<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VHasilAkhir;

/**
 * VHasilAkhirSearch represents the model behind the search form about `app\models\VHasilAkhir`.
 */
class HasilAkhirSearch extends VHasilAkhir
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_karyawan','id_bulan','id_tahun'], 'integer'],
            [['total'], 'number'],
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
        $query = VHasilAkhir::find();

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
            'total'       => $this->total,
            'id_karyawan' => $this->id_karyawan,
            'id_bulan'    => $this->id_bulan,
            'id_tahun'    => $this->id_tahun,
            'create_at'   => $this->create_at,
            'update_at'   => $this->update_at,
        ]);

        return $dataProvider;
    }
}
