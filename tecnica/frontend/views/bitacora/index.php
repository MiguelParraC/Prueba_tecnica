<?php

use frontend\models\Bitacora;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var frontend\models\BitacoraSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Bitacoras');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitacora-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            [
                'attribute' => 'user',
                'label' => Yii::t('app', 'Quien Creó'),
                'value' => function ($model) {
                    if ($model->user != '') {
                        $usuario_crea = \common\models\User::find()->where(['id' => $model->user])->one();
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
                    'user',
                    $searchModel->lista_quien_creo,
                    ['class' => 'form-control', 'prompt' => 'VER TODOS']

                ),
            ],
            [
                'attribute' => 'accion',
                'label' => Yii::t('app', 'Quien Creó'),
                'value' => function ($model) use ($searchModel){
                    if ($model->accion != '') {
                        return $searchModel->list_action[$model->accion];
                    } else {
                        return '';
                    }
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'accion',
                    $searchModel->list_action,
                    ['class' => 'form-control', 'prompt' => 'VER TODOS']

                ),
            ],
            'descripcion:ntext',
            'created_at',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Bitacora $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //     }
            // ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>