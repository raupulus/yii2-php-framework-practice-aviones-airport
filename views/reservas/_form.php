<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reservas */
/* @var $form yii\widgets\ActiveForm */
/* @var $plazas Array con todas las plazas libres*/
?>

<div class="reservas-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'asiento')->dropDownList($plazas) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
