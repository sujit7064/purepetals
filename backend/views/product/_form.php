<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        $categories,
        ['prompt' => 'Select Category']
    ) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->fileInput(['required' => ($model->image != '') ? false : true]) ?> <br>

    <?= $form->field($model, 'multiple_image[]')->fileInput(['multiple' => true]) ?>

    <?= $form->field($model, 'cut_price')->textInput(['type' => 'number', 'min' => 0])->label('Cut Price') ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>

    <?= $form->field($model, 'details')->textarea([
        'rows' => 10,
        'placeholder' => "Enter specifications like:\nBrand: Forest Gold,\nModel Name: XYZ,\nOrganic: Yes"
    ]) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>