<?php

use app\models\Reservas;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id:text:Identificador',
            'nombre',
            //'password',
        ],
    ]) ?>

    <h3>Vuelos de este usuario</h3>

    <?php
        $reservas = Reservas::find()->where([
            'usuario_id' => $model->id,
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $reservas,
        ]);
    ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'id',
                'label' => 'Reserva',
                'format' => 'raw',
                'value' => function($model,$key) {
                    return Html::a($key, ['reservas/view', 'id' =>
                        $key]);
                },
            ],
            [
                'attribute' => 'vuelo.codigo',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::a($model->vuelo->codigo, ['vuelos/view', 'id' =>
                        $model->vuelo_id]);
                },
            ],
            'vuelo.origen.denominacion:text:Aeropuerto de Origen',
            'vuelo.destino.denominacion:text:Aeropuerto de Destino',
            'vuelo.precio:currency:Precio',
            'vuelo.salida:datetime:Fecha de salida',
            'vuelo.llegada:datetime:Fecha de llegada',
            'asiento',
        ]
    ]);
    ?>

</div>
