<?php

use frontend\models\ProductsPool;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\ProductspoolSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Lita de Productos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-pool-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->identity->add_new_product == 1) { ?>
        <p>
            <?= Html::a(Yii::t('app', 'Crear nuevo Producto'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'condensed' => true,
        // 'perfectScrollbar' => true,
        // 'floatHeader' => true,
        // 'export' => false,
        // 'toggleData' => false,
        // 'headerContainer' => ['class' => 'kv-table-header'/*, 'style' => 'top: 50px'*/],
        // 'containerOptions' => ['class' => 'kv-grid-wrapper', 'style' => 'height: 80vh;'],
        //        'toggleData' => false,
        // 'panel' => [
        //     //'type' => 'primary',
        //     'heading' =>
        //     '<div style="display:flex; justify-content:flex-start;align-items:center">' 
        //         . Html::a('<i class="fas fa-redo"></i> RESET DEL FILTRADO', ['index'], ['class' => 'btn btn-info'])
        //         . '&nbsp&nbsp&nbsp&nbsp'
        //         . '</div>',

        //     //'before' => Html::a('<i class="fas fa-redo"></i> Reset del Filtrado', ['index'], ['class' => 'btn btn-info']),
        //     'footer' => ""
        // ],

        'pager' => [
            'options' => ['class' => 'pagination'],   // set clas name used in ui list of pagination
            'prevPageLabel' => Yii::t('app', 'Anterior'),   // Set the label for the "previous" page button
            'nextPageLabel' => Yii::t('app', 'Siguiente'),   // Set the label for the "next" page button
            'firstPageLabel' => Yii::t('app', 'Primera'),   // Set the label for the "first" page button
            'lastPageLabel' => Yii::t('app', 'Última'),    // Set the label for the "last" page button
            'nextPageCssClass' => 'next',    // Set CSS class for the "next" page button
            'prevPageCssClass' => 'prev',    // Set CSS class for the "previous" page button
            'firstPageCssClass' => 'first',    // Set CSS class for the "first" page button
            'lastPageCssClass' => 'last',    // Set CSS class for the "last" page button
            'maxButtonCount' => 10,    // Set maximum number of page buttons that can be displayed

        ],
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


            // 'id',
            [
                'attribute' => 'product_id',
                'value' => function ($model) use ($searchModel) {

                    if ($model->id != '') {
                        return Yii::t('app', $searchModel->list_produc[$model->id]);
                    } else {
                        return Yii::t('app', 'Error!!');
                    }
                },
                'label' => Yii::t('app', 'Producto'),
                'contentOptions' => [
                    'style' => 'text-align:center;'
                ],
                'headerOptions' => [
                    'style' => 'text-align:center;'
                ],
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'product_id',
                    $searchModel->list_produc,
                    ['class' => 'form-control', 'prompt' => 'VER TODOS']
                ),
            ], // Producto
            [
                'attribute' => 'status',
                'value' => function ($model) use ($searchModel) {

                    if ($model->status !== '') {
                        return Yii::t('app', $searchModel->list_status[$model->status]);
                    } else {
                        return Yii::t('app', $searchModel->list_status[1]);
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
                    $searchModel->list_status,
                    ['class' => 'form-control', 'prompt' => 'VER TODOS']
                ),
            ], // Status
            'price',
            'stock',
            [
                'attribute' => 'who_created',
                'label' => Yii::t('app', 'Quien Creó'),
                'value' => function ($model) {
                    if ($model->who_created != '') {
                        $usuario_crea = \common\models\User::find()->where(['id' => $model->who_created])->one();
                        if ($usuario_crea) {
                            return $usuario_crea->username;
                        } else {
                            return '';
                        }
                    } else {
                        return '';
                    }
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'who_created',
                    $searchModel->lista_quien_creo,
                    ['class' => 'form-control', 'prompt' => 'VER TODOS']

                ),
            ], // Quien procesó
            //'who_created',
            //'created_at',
            //'who_updated',
            //'updated_at',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, ProductsPool $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     }
            // ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>