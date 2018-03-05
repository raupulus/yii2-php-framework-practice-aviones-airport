<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VuelosSearch represents the model behind the search form of `app\models\Vuelos`.
 */
class VuelosSearch extends Vuelos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'origen_id', 'destino_id', 'compania_id'], 'integer'],
            [['codigo', 'salida', 'llegada', 'origen.denominacion', 'destino.denominacion', 'compania.denominacion'], 'safe'],
            [['plazas', 'precio'], 'number'],
        ];
    }

    // Sobrescribe atributos del padre añadiendo origen, destino y compañía
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'origen.denominacion',
            'destino.denominacion',
            'compania.denominacion',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        // Creo la consulta de vuelos concatenando tablas
        $Vuelos = Vuelos::find()
            ->joinWith(['reservas', 'origen', 'compania'])

            ->select('vuelos.*, (vuelos.plazas - count(vuelo_id)) as libres')
            ->having('vuelos.plazas - count(vuelo_id) > 0')

            // Compruebo que la fecha de salida sea mayor a la actual
            ->where(['>', 'salida', date('Y-m-d H:i:s')])

            ->groupBy('vuelos.id, vuelo_id, aeropuertos.denominacion, companias.denominacion');

        $dataProvider = new ActiveDataProvider([
            'query' => $Vuelos,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // Ordenación para plazas libres
        $dataProvider->sort->attributes['libres'] = [
            'asc' => ['libres' => SORT_ASC],
            'desc' => ['libres' => SORT_DESC],
        ];

        // Ordenación para denominación del origen
        $dataProvider->sort->attributes['origen.denominacion'] = [
            'asc' => ['aeropuertos.denominacion' => SORT_ASC],
            'desc' => ['aeropuertos.denominacion' => SORT_DESC],
        ];

        // Ordenación para denominación del destino
        $dataProvider->sort->attributes['destino.denominacion'] = [
            'asc' => ['aeropuertos.denominacion' => SORT_ASC],
            'desc' => ['aeropuertos.denominacion' => SORT_DESC],
        ];

        // Ordenación para denominación de compañía
        $dataProvider->sort->attributes['compania.denominacion'] = [
            'asc' => ['companias.denominacion' => SORT_ASC],
            'desc' => ['companias.denominacion' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $Vuelos->andFilterWhere([
            'salida' => $this->salida,
            'llegada' => $this->llegada,
            'plazas' => $this->plazas,
            'precio' => $this->precio,
        ]);

        $Vuelos->andFilterWhere(['ilike', 'codigo', $this->codigo]);

        $Vuelos->andFilterWhere(['ilike', 'aeropuertos.denominacion', $this->getAttribute('origen.denominacion')]);

        $Vuelos->andFilterWhere(['ilike', 'aeropuertos.denominacion', $this->getAttribute('destino.denominacion')]);

        $Vuelos->andFilterWhere(['ilike', 'companias.denominacion', $this->getAttribute('compania.denominacion')]);

        return $dataProvider;
    }
}
