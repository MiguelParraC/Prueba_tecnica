<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var frontend\models\ProductsPool $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="products-pool-form container mt-4 styles_form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'row g-3'], // Clases de Bootstrap 5 para el formulario y el espaciado entre filas
    ]); ?>

    <?php if (!empty($model->list_categories)) { ?>

        <div class="row">
            <div class="offset-md-2 col-md-8">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'onkeyup' => 'converToMayus(this); cuenta_mensaje(this,"contador-1")', 'class' => 'form-control bg-light border-primary']) ?>
                <div class="row">
                    <div class="offset-md-5" id="contador-1">0/255</div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (Yii::$app->user->identity->activate_products == 1) {
                $disable_status = false;
            } else {
                $disable_status = true;
            } ?>
            <div class="col-md-4">
                <?= $form->field($model, 'status')->dropDownList($model->list_status, [
                    'class' => 'form-control bg-light border-primary',
                    'disabled' => $disable_status,
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'price')->textInput([
                    'type' => 'number',
                    'class' => 'form-control bg-light border-primary',
                    'min' => 0
                ]) ?>
            </div>
            <?php if (Yii::$app->user->identity->add_num_products == 1) {
                $read_add = false;
            } else {
                $read_add = true;
            } ?>
            <div class="col-md-4">
                <?= $form->field($model, 'stock')->textInput([
                    'readonly' => $read_add,
                    'type' => 'number',
                    'class' => 'form-control bg-light border-primary',
                    'onchange' => 'check_stock(this)',
                    'min' => 0
                ]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'category_id')->dropDownList($model->list_categories, [
                    'disabled' => $disable_status,
                    'class' => 'form-control bg-light border-primary',
                    'onchange' => 'check_stock(this)',
                ]) ?>
            </div>


            <div style="display: none;">
                <?= $form->field($model, 'aux_stock')->textInput([
                    'type' => 'number',
                    'readonly' => true,
                    'min' => 0
                ]) ?>
            </div>


        </div>
        <hr style="border: 1px solid #000;">
        <?php if ($model->model_action != 'create') { ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name_user_create')->textInput(['class' => 'form-control border-primary', 'disabled' => 'disabled']) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'created_at')->textInput(['class' => 'form-control border-primary', 'disabled' => 'disabled']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name_user_updated')->textInput(['class' => 'form-control border-primary', 'disabled' => 'disabled'])->label('Usuario que creó') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'updated_at')->textInput(['class' => 'form-control border-primary', 'disabled' => 'disabled'])->label('Usuario que actualizó') ?>
                </div>
            </div>


        <?php } ?>
        <div class="col-12 text-center">
            <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success guardar-class']) ?>
        </div>

    <?php } else { ?>
        <div class="alert alert-warning text-center" role="alert">
            <?= Yii::t('app', 'No hay categorías disponibles. Por favor, crea una categoría antes de agregar un producto.') ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
    <?php
    $this->registerJsFile(
        '@web/js/products.js',
        // '@web/js/main_v0.1.js',
        ['depends' => [\yii\web\JqueryAsset::className()]]

    );
    ?>
</div>