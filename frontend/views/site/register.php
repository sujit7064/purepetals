<?php
use yii\helpers\Html;

$this->title = 'Register';
?>

<div class="register-container">
    <div class="card shadow-lg p-4 rounded">
        <h2 class="text-center text-primary mb-4"><?= Html::encode($this->title) ?></h2>

        <form action="<?= Yii::$app->urlManager->createUrl(['site/register']) ?>" method="post" enctype="multipart/form-data" class="needs-validation">
        <input type="hidden" name="_csrf-frontend" value="<?= Yii::$app->request->csrfToken ?>">


            <div class="row">
                <div class="col-md-6">
                    <label for="company_name"><i class="fas fa-building"></i> Company Name</label>
                    <input type="text" class="form-control" name="company_name" placeholder="Enter your Company Name" required>
                </div>
                <div class="col-md-6">
                    <label for="phone_number"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" class="form-control" name="phone_number" placeholder="Enter your Phone Number" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your Email" required>
                </div>
                <div class="col-md-6">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Create a Password" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="logo"><i class="fas fa-image"></i> Upload Company Logo</label>
                    <input type="file" class="form-control" name="logo">
                </div>
            </div>

            <div class="form-group text-center mt-3">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>

            <p class="text-center">Already have an account? 
                <?= Html::a('Login', ['site/login'], ['class' => 'btn btn-link']) ?>
            </p>
        </form>
    </div>
</div>

<!-- Custom Styling -->
<style>
    .register-container {
        max-width: 600px;
        margin: 50px auto;
    }
    .card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    h2 {
        font-weight: bold;
    }
    label {
        font-weight: bold;
        color: #555;
    }
    .btn-primary {
        background: #007bff;
        border: none;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #0056b3;
    }
</style>
