<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="login-container">
    <h2>Login</h2>

    <?php $form = ActiveForm::begin(['action' => ['site/login'], 'method' => 'post']); ?>

    <!-- </?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>
    </?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?> -->

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    </div>

    <p>Don't have an account? 
        <?= Html::a('Sign Up', ['site/register'], ['class' => 'btn btn-link']) ?>
    </p>

    <?php ActiveForm::end(); ?>
</div>
