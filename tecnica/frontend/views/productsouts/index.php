<?php

use frontend\models\ProductsOuts;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\ProductsoutsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

// $this->title = Yii::t('app', 'Products Outs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-outs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'SALIDA DE PRODUCTOS'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php if (Yii::$app->user->identity->id == 1) { ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'options' => ['class' => 'action-column'],
                    'buttons' => [
                        'view' => function () {
                            return '';
                        },
                        'delete' => function () {
                            return '';
                        },

                        'update' => function ($url, $model, $key) {
                            if (Yii::$app->user->identity->id == 1) {
                                return Html::a("<span class='bi bi-pencil-fill btn btn-primary' style='position: static;'></span>", $url);
                            } else {
                                return '';
                            }
                        },
                    ]
                    // 'template' => '{view}{update}',
                ],
                // 'id',
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
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) use ($searchModel) {
                        return isset($model->created_at) ? $model->created_at : '';
                    }

                ],
                [
                    'attribute' => 'who_updated',
                    'label' => Yii::t('app', 'Quien Actualizó'),
                    'value' => function ($model) {
                        if ($model->who_updated != '') {
                            $usuario_crea = \common\models\User::find()->where(['id' => $model->who_updated])->one();
                            if ($usuario_crea) {
                                return $usuario_crea->username;
                            } else {
                                return '//';
                            }
                        } else {
                            return '//';
                        }
                    },
                    'filter' => Html::activeDropDownList(
                        $searchModel,
                        'who_updated',
                        $searchModel->lista_quien_actualiza,
                        ['class' => 'form-control', 'prompt' => 'VER TODOS']

                    ),
                ],
                [
                    'attribute' => 'updated_at',
                    'value' => function ($model) use ($searchModel) {
                        return isset($model->updated_at) ? $model->updated_at : '//';
                    },

                ],

            ],
        ]); ?>
    <?php } ?>
    <?php Pjax::end(); ?>

</div>