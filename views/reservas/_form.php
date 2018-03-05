<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reservas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $vuelos = \app\models\Vuelos::listaPlazasLibres($model->id) ?>

    <?php // $form->field($model, 'asiento')->textInput() ?>

    <?= $form->field($model, 'asiento')->dropDownList($vuelos) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
