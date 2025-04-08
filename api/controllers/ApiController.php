<?php

namespace api\controllers;


use common\models\Product;
use Yii\db\Exception;
use Yii;
use yii\app;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use common\models\User;
use common\models\LoginForm;


class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' => ['POST', 'GET'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['POST', 'HEAD', 'GET', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['authorization', 'Authorization', 'X-Requested-With'],
                ],
            ],
            // 'authenticator' => [
            //     'class' => \yii\filters\auth\HttpBearerAuth::className(),
            //     'except' => ['login','index','reset_password','registration','login','resetpassword']
            // ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        if (parent::beforeAction($action)) {
            return true;
        }
        return parent::beforeAction($action);
    }


    public function actionIndex() {}

    public function actionRegistration()
    {
        $rest = array();
        $message = '';

        $phone_number = Yii::$app->request->post('phone_number');
        $password = Yii::$app->request->post('password');
        $hash =  Yii::$app->getSecurity()->generatePasswordHash($password);
        $name = Yii::$app->request->post('name');
        $email = Yii::$app->request->post('email');


        $transaction = Yii::$app->db->beginTransaction();

        try {
            if ($phone_number != '' && $password != ''  && $name != '') {

                $usermodel = User::find()->where(['username' => $phone_number])->one();
                if ($usermodel) {
                    throw new \Exception('Phone Number Already Exist');
                    $status = 0;
                }
                $user_model = new User();
                $user_model->username = $phone_number;
                $user_model->password_hash = $hash;
                $user_model->role_id = 2;
                $user_model->status = 10;
                $user_model->email = $email;

                if ($user_model->save()) {

                    $message = "Registration Successful";
                    $status = 1;
                } else {
                    $message = "Ooops! Something Went Wrong";
                    $status = 0;
                }
            } else {
                throw new \Exception('Please fill up all field');
                $status = 0;
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            $message = $e->getMessage();
            $status = 0;
        }

        $rest['message'] = $message;
        $rest['status'] = $status;

        return $this->asJson($rest);
    }

    public function actionLogin()
    {
        $phone_number = Yii::$app->request->post('phone_number');
        $password = Yii::$app->request->post('password');
        $userModel = User::find()->where(['username' => $phone_number])->one();
        if (!$userModel) {
            return $this->asJson([
                'message' => "Failed to login",
                'status' => 0,
                'data' => null,
            ]);
        }
        if ($userModel) {

            $logmodel = new LoginForm();
            $logmodel->username = $phone_number;
            $logmodel->password = $password;
            if ($logmodel->login()) {
                $message = "Login success";
                $status = 1;
                $data = [
                    'user_id' => $userModel->id,
                    'role_id' => $userModel->role_id,
                ];
            } else {
                $message = "Wrong Password";
                $status = 0;
                $data = 0;
            }
        } else {
            $message = "User doesn't Exist";
            $status = 0;
            $data = 0;
        }
        $rest['message'] = $message;
        $rest['status'] = $status;
        $rest['data'] = $data;
        return $this->asJson($rest);
    }
    public function actionProductlist()
    {
        $rest = $data = [];
        $products = Product::find()->where(['is_delete' => 0])->all();

        if ($products) {
            foreach ($products as $product) {
                $message = " List available";
                $status = 1;
                $data[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'image' => Yii::getAlias('@storageUrl') . '/images/'  . $product->image
                ];
            }
        } else {
            $message = "List not available";
            $status = 0;
        }
        $rest['message'] = $message;
        $rest['status'] = $status;
        $rest['data'] = $data;

        return $this->asJson($rest);
    }

    public function actionBannerproduct()
    {
        $rest = $data = [];
        $products = Product::find()->where(['status' => 1, 'is_delete' => 0])->all();

        if ($products) {
            foreach ($products as $product) {
                $message = " List available";
                $status = 1;
                $data[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'image' => Yii::getAlias('@storageUrl') . '/images/'  . $product->image
                ];
            }
        } else {
            $message = "List not available";
            $status = 0;
        }
        $rest['message'] = $message;
        $rest['status'] = $status;
        $rest['data'] = $data;

        return $this->asJson($rest);
    }
}
