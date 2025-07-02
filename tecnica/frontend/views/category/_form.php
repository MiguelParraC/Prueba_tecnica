<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form container mt-4 styles_form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'row g-3'], // Clases de Bootstrap 5 para el formulario y el espaciado entre filas
    ]); ?>

    <div class="row">
        <div class="offset-md-2 col-md-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'onkeyup' => 'converToMayus(this); cuenta_mensaje(this,"contador-1")', 'class' => 'form-control bg-light border-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-1 col-md-4">
            <?= $form->field($model, 'status')->dropDownList($model->list_status, [
                'class' => 'form-control bg-light border-primary',
            ]) ?>
        </div>

        <?php if ($model->view != 'create'): ?>

            <div class="row">
                <div class="offset-md-1 col-md-6">
                    <?= $form->field($model->whoCreated, 'username')->textInput(['readonly' => true])->label(Yii::t('app', 'Creado por')) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'created_at')->textInput(['readonly' => true])->label(Yii::t('app', 'Creado el')) ?>
                </div>
            </div>

            <div class="row">
                <div class="offset-md-1 col-md-6">
                    <?= $form->field($model->whoUpdated, 'username')->textInput(['readonly' => true])->label(Yii::t('app', 'Actualizado por')) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'updated_at')->textInput(['readonly' => true])->label(Yii::t('app', 'Actualizado el')) ?>
                </div>
            </div>
        <?php endif; ?>
        <br>
    </div>
    <hr style="border: 1px solid #000;">
    <div class="col-12 text-center">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success guardar-class']) ?>
    </div>


    <?php ActiveForm::end(); ?>


</div>