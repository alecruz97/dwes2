<?php

use kartik\datecontrol\DateControl;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="libros-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'num_pags')->textInput() ?>

    <?= $form->field($model, 'genero_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->widget(DateControl::class) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
