<?php

use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/** @var yii\web\View $this */
/** @var frontend\models\ProductsSales $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="products-pool-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $hidden_add = 'btn btn-primary';
    $hidden_remove = 'btn btn-danger';
    ?>

    <?= $form->field($model, 'sales_products')->widget(MultipleInput::className(), [
        'max' => $model->count_products,
        'allowEmptyList' => false,
        'data' => (isset($data)) ?  $data : null,

        'options' => [
            'style' => "text-align:left;",
            // 'class' => "form-medem",
            'text-transform' => 'uppercase',
            'height' => '',
            'width' => '100%',
        ],
        'addButtonOptions' => [
            'class' => $hidden_add,
            'label' => '<i class="fas fa-plus"></i>', // Ícono Font Awesome
            'encode' => false, // Importante para permitir HTML en el label
            // 'options' => function () {
            //     $array_options = [];
            //     $array_options['onclick'] = 'creaDiagnostico(this)';
            //     $array_options['style'] = ['display' => 'none', 'width' => '100%'];
            //     return $array_options;
            // }
        ],
        'removeButtonOptions' => [
            'class' => $hidden_remove,
            'label' => '<i class="fas fa-trash"></i>', // ��cono Font Awesome
        ],
        'columns' => [
            [
                'name' => 'product',
                'title' => 'Productos a retirar',
                'items' => $model->list_products,
                'type' =>   'DropDownList', //'textArea',
                'options' => function () {
                    $array_options = [];
                    $array_options['prompt'] = 'Seleccione...';
                    $array_options['required'] = true;
                    $array_options['onchange'] = 'change_product(this)';
                    return $array_options;
                },
                'headerOptions' => [
                    'style' => ['width' => '60%'],

                ]

            ],
            [
                'name' => 'quantity',
                'title' => 'Cantidad',
                'type' => 'textInput',
                'options' => function ($model) {
                    return [
                        'type' => 'number',
                        'min' => 1, 
                        'class' => 'form-control',
                        'required' => true,
                        'onchange' => 'change_quantity(this)',

                    ];
                },
                'headerOptions' => [
                    'style' => ['width' => '20%'],
                ]
            ],
            [
                'name' => 'stock',
                'title' => 'Stock',
                'type' => 'textInput',
                'options' => function ($model) {
                    return [
                        'type' => 'number',
                        'class' => 'form-control',
                        'readonly' => true,
                    ];
                },
                'headerOptions' => [
                    'style' => ['width' => '20%'],
                ]
            ],

        ],
    ])->label('');
    ?>



    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success guardar-class']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $this->registerJsFile(
        '@web/js/product_out.js',
        // '@web/js/main_v0.1.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]

    );
    ?>
</div>