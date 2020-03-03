<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Lectores */

$this->title = 'Create Lectores';
$this->params['breadcrumbs'][] = ['label' => 'Lectores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lectores-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
