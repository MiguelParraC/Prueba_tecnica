<?php

use frontend\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Categorías');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Categoría'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'options' => ['class' => 'action-column'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a("<span class='bi bi-eye-fill btn btn-info p-1' style='font-size:1rem;'></span>", $url, [
                            'title' => 'Ver',
                            'data-pjax' => '0',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a("<span class='bi bi-pencil-fill btn btn-primary p-1' style='font-size:1rem;'></span>", $url, [
                            'title' => 'Editar',
                            'data-pjax' => '0',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a("<span class='bi bi-trash-fill btn btn-danger p-1' style='font-size:1rem;'></span>", $url, [
                            'title' => 'Eliminar',
                            'data-pjax' => '0',
                            'data-confirm' => '¿Estás seguro que deseas eliminar este registro?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
            'id',
            'name',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status !== '') {
                        return $model->status == 1 ? 'Activo' : ($model->status == 0 ? 'Inactivo' : 'Eliminado');
                    } else {
                        return 'Activo';
                    }
                },
                'label' => Yii::t('app', 'Status'),
                'contentOptions' => function ($model) {
                    // 0: Inactivo (amarillo), 1: Activo (verde), 2: Eliminado (rojo)
                    if ($model->status == 1) {
                        return ['style' => 'text-align:center; background-color:#d4edda; color:#155724;']; // verde suave
                    } elseif ($model->status == 0) {
                        return ['style' => 'text-align:center; background-color:#fff3cd; color:#856404;']; // amarillo suave
                    } elseif ($model->status == 2) {
                        return ['style' => 'text-align:center; background-color:#f8d7da; color:#721c24;']; // rojo suave
                    } else {
                        return ['style' => 'text-align:center;'];
                    }
                },
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status',
                    [0 => 'Inactivo', 1 => 'Activo', 2 => 'Eliminado'],
                    ['class' => 'form-control', 'prompt' => 'VER TODOS']
                ),
            ],
            'who_created',
            'created_at',
            //'who_updated',
            //'updated_at',
            
        ],
    ]); ?>


</div>
