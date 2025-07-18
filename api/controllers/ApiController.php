<?php

namespace api\controllers;

use common\models\AddressDetails;
use common\models\CartItem;
use common\models\Product;
use Yii\db\Exception;
use Yii;
use yii\app;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use common\models\User;
use common\models\LoginForm;
use common\models\OrderDetails;
use common\models\PaymentDetails;
use common\models\Registration;

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
        $status = 0;
        $data = [];

        // Fetch POST data
        $phone_number = Yii::$app->request->post('phone_number');
        $password = Yii::$app->request->post('password');
        $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        $name = Yii::$app->request->post('name');
        $email = Yii::$app->request->post('email');

        // Start a transaction to ensure rollback in case of error
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Validate input fields
            if (empty($phone_number) || empty($password) || empty($name)) {
                throw new \Exception('Please fill up all fields');
            }

            // Check if phone number already exists
            $usermodel = User::find()->where(['username' => $phone_number])->one();
            if ($usermodel) {
                throw new \Exception('Phone Number Already Exists');
            }
            $usermodel = User::find()->where(['email' => $email])->one();
            if ($usermodel) {
                throw new \Exception('This email Already Exists');
            }

            // Create new User record
            $user_model = new User();
            $user_model->username = $phone_number;
            $user_model->password_hash = $hash;
            $user_model->role_id = 2;
            $user_model->status = 10;  // You can adjust this based on your needs (active/inactive)
            $user_model->email = $email;

            if ($user_model->save()) {
                // Create Registration record
                $registration = new Registration();
                $registration->user_id = $user_model->id;
                $registration->name = $name;
                $registration->phone_number = $phone_number;
                $registration->email = $email;
                $registration->save();

                // Success response
                $message = "Registration Successful";
                $status = 1;
                $data = [
                    'user_id' => $user_model->id,
                    'role_id' => $user_model->role_id,
                    'phone_number' => $user_model->username,
                    'email' => $user_model->email,
                ];
            } else {
                throw new \Exception('Oops! Something Went Wrong while saving user data');
            }

            // Commit the transaction
            $transaction->commit();
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            $transaction->rollBack();
            $message = $e->getMessage();
        }

        // Return response
        $rest['message'] = $message;
        $rest['status'] = $status;
        $rest['data'] = $data;

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
                    'phone_number' => $userModel->username,
                    'email' => $userModel->email,
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
                $message = "List available";
                $status = 1;

                // Decode multiple_image JSON (if not null)
                $multipleImages = [];
                $filenames = json_decode($product->multiple_image, true);

                if (is_array($filenames)) {
                    foreach ($filenames as $filename) {
                        $multipleImages[] = Yii::getAlias('@storageUrl') . '/images/' . $filename;
                    }
                }

                $data[] = [
                    'product_id'     => $product->id,
                    'product_name'   => $product->product_name,
                    'image'          => Yii::getAlias('@storageUrl') . '/images/' . $product->image,
                    'price'          => $product->price,
                    'final_price'    => $product->final_price,
                    'description'    => $product->description,
                    'multiple_image' => $multipleImages,
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
    public function actionAddtocart()
    {
        $rest = [];
        $request = Yii::$app->request;
        $buyer_id = $request->post('buyer_id');
        $product_id = $request->post('product_id');
        $quantity = $request->post('quantity');
        $price = $request->post('price');

        $product = Product::findOne(['id' =>  $product_id]);

        try {
            if ($product) {
                $existingCartItem = CartItem::find()->where(['product_id' => $product_id, 'buyer_id' => $buyer_id])->one();
                if ($existingCartItem) {
                    $existingCartItem->product_quantity += $quantity;
                    $base_amount = $existingCartItem->product_quantity * $price;
                    $existingCartItem->total_amount = $base_amount;
                    if ($existingCartItem->save()) {
                        $message = 'Order updated successfully.';
                        $status = 1;
                    } else {
                        $message = 'Failed to update the order.';
                        $status = 0;
                    }
                } else {
                    $formattedDate = date('d-m-Y');
                    $orderDetails = new CartItem();
                    $orderDetails->buyer_id = $buyer_id;
                    $orderDetails->product_id = $product_id;
                    $orderDetails->product_quantity = $quantity;
                    $orderDetails->order_date = $formattedDate;
                    $orderDetails->product_price = $price;
                    $total_amount =   $price * $quantity;

                    $orderDetails->total_amount = $total_amount;
                    if ($orderDetails->save()) {
                        $message = 'Item add to cart successfully.';
                        $status = 1;
                    } else {
                        $message = 'Failed to save order details.';
                        $status = 0;
                    }
                }
            }
        } catch (Exception $e) {
            $message = 'An error occurred: ' . $e->getMessage();
            $status = 0;
        }

        $rest['message'] = $message;
        $rest['status'] = $status;

        return $this->asJson($rest);
    }

    public function actionCartitemlist()
    {
        $rest = [];
        $request = Yii::$app->request;
        $buyer_id = $request->post('buyer_id');
        try {
            $cartItems = CartItem::find()->where(['buyer_id' => $buyer_id])->all();
            $totalcartamount = CartItem::find()->where(['buyer_id' => $buyer_id])->sum('total_amount');
            $delivery_charges = 49;
            if ($cartItems) {
                $cartDetails = [];
                $baseUrl = Yii::$app->request->baseUrl;

                foreach ($cartItems as $item) {
                    $buyer_name = Registration::find()->where(['user_id' => $item->buyer_id])->one();
                    $image = Product::find()->where(['id' => $item->product_id])->one();
                    $imagee =  $image->image;
                    $fullImageUrl = $imagee ?  Yii::getAlias('@storageUrl') . '/images/' . $imagee : '';

                    $cartDetails['cart_items'][] = [
                        'cart_item_id' => $item->id,
                        'product_quantity' => $item->product_quantity,
                        'product_price' => number_format($item->product_price, 2, '.', ''),
                        'total_amount' => number_format($item->total_amount, 2, '.', ''),
                        'order_date' => date('d-m-Y', strtotime($item->order_date)),
                        'delivery_date' => date('d-m-Y', strtotime($item->order_date . ' +7 days')),
                        'image' =>  $fullImageUrl
                    ];
                }
                $cartDetails['total_amount'] = number_format($totalcartamount, 2, '.', '');
                $cartDetails['delivery_charge'] = $delivery_charges;
                $cartDetails['to_pay'] = number_format($totalcartamount + $delivery_charges, 2, '.', '');
                $rest['message'] = 'Cart items retrieved successfully.';
                $rest['status'] = 1;
                $rest['data'] = $cartDetails;
            } else {
                $rest['message'] = 'No cart items found for the provided buyer ID.';
                $rest['status'] = 0;
            }
        } catch (Exception $e) {
            $rest['message'] = 'An error occurred: ' . $e->getMessage();
            $rest['status'] = 0;
        }

        return $this->asJson($rest);
    }
    public function actionCancelcartitem()
    {
        $buyer_id = Yii::$app->request->post('buyer_id');

        $cart_item_id = Yii::$app->request->post('cart_item_id');

        $cartItem = CartItem::find()->where(['buyer_id' => $buyer_id, 'id' => $cart_item_id])->one();

        if ($cartItem) {
            $cartItem->delete();
            $message = "Cart item deleted successfully";
            $status = 1;
        } else {
            $message = "Product not found";
            $status = 0;
        }

        $rest = [
            'message' => $message,
            'status' => $status,
        ];

        return $this->asJson($rest);
    }
    public function actionAddadress()
    {
        $user_id = Yii::$app->request->post('user_id');
        $city = Yii::$app->request->post('city');
        $dist = Yii::$app->request->post('dist');
        $state = Yii::$app->request->post('state');
        $pincode = Yii::$app->request->post('pincode');
        $address = Yii::$app->request->post('address');

        $adress = new AddressDetails();
        $adress->user_id = $user_id;
        $adress->city = $city;
        $adress->dist = $dist;
        $adress->state = $state;
        $adress->pincode = $pincode;
        $adress->address = $address;
        $adress->save();
        if ($adress->save()) {
            $message = "address saved suceesfully";
            $status = 1;
        } else {
            $message = "something went wrong";
            $status = 0;
        }
        $rest = [
            'message' => $message,
            'status' => $status,
        ];
        return $this->asJson($rest);
    }
    public function actionAlladdreslist()
    {
        $rest = [];
        $user_id = Yii::$app->request->post('user_id');

        $address = AddressDetails::find()->where(['user_id' => $user_id])->all();

        if ($address) {
            foreach ($address as $adresss) {
                $details['address'][] = [
                    'id' => $adresss->id,
                    'address' => $adresss->address,
                    'city' => $adresss->city,
                    'dist' => $adresss->dist,
                    'state' => $adresss->state,
                    'pincode' => $adresss->pincode,
                ];
            }

            $rest['message'] = 'Address fetched Succesfully.';
            $rest['status'] = 1;
            $rest['data'] = $details;
        } else {
            $rest['message'] = 'Address not found';
            $rest['status'] = 0;
        }

        return $this->asJson($rest);
    }
    public function actionMakeorder()
    {
        $rest = [];
        $buyer_id = Yii::$app->request->post('buyer_id');
        $cart_items = Yii::$app->request->post('cart_item');
        $paymentdetails_id = Yii::$app->request->post('paymentdetails_id');
        $address_id = Yii::$app->request->post('address_id');
        $total_amount = Yii::$app->request->post('total_amount');

        if (!$buyer_id || !$cart_items || !is_array($cart_items)) {
            $rest['message'] = 'Invalid input';
            $rest['status'] = 0;
        }

        foreach ($cart_items as $item) {
            $cartItem = CartItem::find()->where(['id' => $item['cart_item_id']])->one();
            if ($cartItem) {
                $orderDetail = new OrderDetails();
                $orderDetail->buyer_id = $buyer_id;
                $orderDetail->product_id = $cartItem->product_id;
                $orderDetail->product_quantity = $item['product_quantity'];
                $orderDetail->paymentdetails_id = $paymentdetails_id;
                $orderDetail->address_id = $address_id;
                $orderDetail->total_amount = $item['product_quantity'] * $cartItem->product_price;

                if ($orderDetail->save()) {
                    $cartItem->delete();
                    $rest['message'] = 'Order confirmed';
                    $rest['status'] = 1;
                } else {
                    $rest['message'] = 'Failed to save order detail';
                    $rest['status'] = 0;
                }
            } else {
                $rest['message'] = 'Cart item not found';
                $rest['status'] = 0;
            }
        }

        return $this->asJson($rest);
    }
    public function actionAllorderlist()
    {
        $buyer_id = Yii::$app->request->post('buyer_id');
        $rest = [];

        if (!$buyer_id) {
            return [
                'status' => 0,
                'message' => 'buyer_id is required',
            ];
        }

        $orders = OrderDetails::find()
            ->where(['buyer_id' => $buyer_id, 'is_delete' => 0])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        if ($orders) {
            $details = [];
            foreach ($orders as $order) {
                $products = Product::find()->where(['id' => $order->product_id, 'is_delete' => 0])->one();

                $details['orders'][] = [
                    'id' => $order->id,
                    'image' => Yii::getAlias('@storageUrl') . '/images/'  . $products->image,
                    'product_quantity' => $order->product_quantity,
                    //'paymentdetails_id' => $order->paymentdetails_id,
                    //'address_id' => $order->address_id,
                    'total_amount' => $order->total_amount,
                    'order_date' => $order->order_date,
                    'status' => OrderDetails::STATUSES[$order->order_status] ?? 'Unknown',
                    'status_no' => $order->order_status ?? 'Unknown',
                ];
            }

            $rest['message'] = 'Orders fetched successfully.';
            $rest['status'] = 1;
            $rest['data'] = $details;
        } else {
            $rest['message'] = 'No orders found for this buyer.';
            $rest['status'] = 0;
        }

        return $this->asJson($rest);
    }
    public function actionPendingorders()
    {
        $buyer_id = Yii::$app->request->post('buyer_id');
        $rest = [];

        if (!$buyer_id) {
            return [
                'status' => 0,
                'message' => 'buyer_id is required',
            ];
        }

        $orders = OrderDetails::find()
            ->where(['buyer_id' => $buyer_id, 'order_status' => 0])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        if ($orders) {
            $details = [];
            foreach ($orders as $order) {
                $products = Product::find()->where(['id' => $order->product_id, 'is_delete' => 0])->one();

                $details['orders'][] = [
                    //'id' => $order->id,
                    'image' => Yii::getAlias('@storageUrl') . '/images/'  . $products->image,
                    'product_quantity' => $order->product_quantity,
                    //'paymentdetails_id' => $order->paymentdetails_id,
                    //'address_id' => $order->address_id,
                    'total_amount' => $order->total_amount,
                    'order_date' => $order->order_date
                ];
            }

            $rest['message'] = 'Orders fetched successfully.';
            $rest['status'] = 1;
            $rest['data'] = $details;
        } else {
            $rest['message'] = 'No orders found for this buyer.';
            $rest['status'] = 0;
        }

        return $this->asJson($rest);
    }
    public function actionProfiledetails()
    {
        $user_id = Yii::$app->request->post('user_id');
        $rest = [];

        $profile = Registration::find()->where(['user_id' => $user_id, 'is_delete' => 0])->one();

        if ($profile) {

            $data = [
                "user_id" => $profile->user_id,
                'name' => $profile->name,
                'phone_number' => $profile->phone_number,
                'email' => $profile->email
            ];


            $rest['message'] = 'Profile details fetched successfully.';
            $rest['status'] = 1;
            $rest['data'] = $data;
        } else {
            $rest['message'] = 'No Profile Found';
            $rest['status'] = 0;
        }

        return $this->asJson($rest);
    }
    public function actionProceedtobuy()
    {
        $buyer_id = Yii::$app->request->post('buyer_id');
        $address_id = Yii::$app->request->post('address_id');
        $total_product_amount = Yii::$app->request->post('total_product_amount');
        $delivery_charges = Yii::$app->request->post('delivery_charges');
        $total_amount = Yii::$app->request->post('total_amount');
        $payment_method = Yii::$app->request->post('payment_method');
        $payment_status = Yii::$app->request->post('payment_status'); // expected: 'paid', 'failed', 'pending'
        $transaction_id = Yii::$app->request->post('transaction_id');

        $cartItems = CartItem::find()->where(['buyer_id' => $buyer_id])->all();

        if (empty($cartItems)) {
            return $this->asJson([
                'message' => 'No items found in the cart',
                'status' => 0,
            ]);
        }

        // Create payment details
        $paymentdetails = new PaymentDetails();
        $paymentdetails->buyer_id = $buyer_id;
        $paymentdetails->total_product_amount = $total_product_amount;
        $paymentdetails->delivery_charges = $delivery_charges;
        $paymentdetails->total_amount = $total_amount / 100;
        $paymentdetails->payment_status = $payment_status;
        $paymentdetails->payment_method = $payment_method;
        $paymentdetails->transaction_id = $transaction_id;

        if ($paymentdetails->save()) {
            // Only proceed if payment status is "paid"
            if (strtolower($payment_status) === 'paid') {
                $paymentdetails_id = $paymentdetails->id;

                foreach ($cartItems as $cartItem) {
                    $orderDetails = new OrderDetails();
                    $orderDetails->buyer_id = $buyer_id;
                    $orderDetails->product_quantity = $cartItem->product_quantity;
                    $orderDetails->order_date = date('Y-m-d H:i:s');
                    $orderDetails->total_amount = $cartItem->total_amount;
                    $orderDetails->paymentdetails_id = $paymentdetails_id;
                    $orderDetails->address_id = $address_id;
                    $orderDetails->product_id = $cartItem->product_id;

                    $orderDetails->save();
                    $cartItem->delete();
                }

                return $this->asJson([
                    'message' => 'Order placed successfully',
                    'status' => 1,
                ]);
            } else {
                return $this->asJson([
                    'message' => 'Payment not completed. Order not placed.',
                    'status' => 0, // custom code for unpaid
                ]);
            }
        } else {
            return $this->asJson([
                'message' => 'Payment details could not be saved',
                'status' => 0,
            ]);
        }
    }

    public function actionUserAddresses()
    {
        $user_id = Yii::$app->request->post('user_id');

        if (!$user_id) {
            return [
                'status' => 0,
                'message' => 'user_id is required',
            ];
        }

        $addresses = AddressDetails::find()
            ->select(['address', 'dist', 'city', 'state', 'pincode'])
            ->where(['user_id' => $user_id])
            ->asArray()
            ->all();

        if (!empty($addresses)) {
            return [
                'status' => 1,
                'message' => 'Addresses found',
                'count' => count($addresses),
                'data' => $addresses,
            ];
        }

        return [
            'status' => 0,
            'message' => 'No address found for this user_id',
            'data' => [],
        ];
    }


    public function actionReturn()
    {
        $order_id = Yii::$app->request->post('order_id');

        $order = OrderDetails::find()
            ->where(['id' => $order_id, 'order_status' => 5, 'is_delete' => 0])
            ->one();

        if (!$order) {
            return ['status' => 2, 'message' => 'Order not found or not eligible for return'];
        }

        $order->order_status = 6;

        if ($order->save(false)) {
            return ['status' => 1, 'message' => 'Order marked as returned'];
        } else {
            return ['status' => 0, 'message' => 'Failed to update order status'];
        }
    }
}
