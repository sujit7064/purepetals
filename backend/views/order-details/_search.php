<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\OrderDetailsSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="order-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'buyer_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'paymentdetails_id') ?>

    <?= $form->field($model, 'address_id') ?>

    <?php // echo $form->field($model, 'product_quantity') ?>

    <?php // echo $form->field($model, 'order_date') ?>

    <?php // echo $form->field($model, 'total_amount') ?>

    <?php // echo $form->field($model, 'order_status') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
