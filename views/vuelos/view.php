<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Vuelos */

$this->title = 'Vuelo con el código '.$model->codigo;
$this->params['breadcrumbs'][] = ['label' => 'Vuelos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vuelos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'codigo',
            'origen.denominacion:text:Origen',
            'destino.denominacion:text:Destino',
            'compania.denominacion:text:Compañía',
            'precio:currency',

            'plazas:text:Total de Plazas',

            'salida:datetime',
            'llegada:datetime',
        ],
    ]) ?>

</div>
