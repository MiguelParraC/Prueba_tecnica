<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\ProductsPool $model */

$this->title = Yii::t('app', 'Create Products Pool');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products Pools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-pool-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
