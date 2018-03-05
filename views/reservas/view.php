<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reservas */

$this->title = 'Reserva realizada';
$this->params['breadcrumbs'][] = ['label' => 'Reservas', 'url' => ['reservas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<hr>

<h3><?= $this->title ?></h3>

<div class="reservas-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'usuario.nombre:text:Nombre de Usuario',
            'vuelo.origen.denominacion:text:Origen',
            'vuelo.destino.denominacion:text:Destino',
            'vuelo.compania.denominacion:text:Compañía',
            'asiento',
            'fecha_hora:datetime:Fecha y hora',
        ],
    ]) ?>

</div>
