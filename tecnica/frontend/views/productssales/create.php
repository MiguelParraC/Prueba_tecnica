<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ProductsSales $model */

$this->title = Yii::t('app', 'Registro de movimientos');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Salida de productos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-sales-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
