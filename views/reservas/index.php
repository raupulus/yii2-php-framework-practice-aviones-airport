<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->user->identity->nombre.', estas son tus reservas:';
$this->params['breadcrumbs'][] = 'Mis Reservas';
?>
<div class="reservas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'vuelo.codigo:text:Código de Vuelo',
            'vuelo.origen.denominacion:text:Aeropuerto de Origen',
            'vuelo.destino.denominacion:text:Aeropuerto de Destino',
            'vuelo.precio:currency:Precio',
            'vuelo.salida:datetime:Fecha de salida',
            'vuelo.llegada:datetime:Fecha de llegada',
            'asiento',
            'fecha_hora:datetime',
            //'usuario.nombre:text:Usuario'
        ],
    ]); ?>
    <div id="detalle"></div>
</div>
