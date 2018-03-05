<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vuelos Disponibles Actualmente';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vuelos-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'codigo',
                'format' => 'raw',
                'value' => function($model, $key) {
                    return Html::a($model->codigo, [
                            'vuelos/view', 'id' => $key
                    ]);
                }
            ],

            'origen.denominacion:text:Origen',
            'destino.denominacion:text:Destino',
            'compania.denominacion:text:Compañía',
            'precio:currency',

            'libres:text:Plazas Libres',
            'plazas:text:Total de Plazas',

            'salida:datetime',
            'llegada:datetime',

            [
                'label' => 'Crear Reserva',
                'format' => 'raw',
                'value' => function($model, $key) {
                    if ($model->plazaslibres > 0) {
                        return Html::a('Reservar Vuelo', ['reservas/create', 'vuelo_id' => $key]);
                    } else {
                        return 'No disponible';
                    }
                }
            ],
        ],
    ]); ?>
</div>
