<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\OrderDetails $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'buyer_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'paymentdetails_id')->textInput() ?>

    <?= $form->field($model, 'address_id')->textInput() ?>

    <?= $form->field($model, 'product_quantity')->textInput() ?>

    <?= $form->field($model, 'order_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_amount')->textInput() ?>

    <?= $form->field($model, 'order_status')->textInput() ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
