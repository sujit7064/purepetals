<?php

use common\models\OrderDetails;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\OrderDetailsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Create Order Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'buyer_id',
                'label' => 'Buyer name',
                'value' => function ($model) {
                    return ($model->buyer->name ?? 'N/A');
                }
            ],
            [
                'label' => 'Buyer Phone number',
                'value' => function ($model) {
                    return ($model->buyer->phone_number ?? 'N/A');
                }
            ],
            [
                'attribute' => 'product_id',
                'label' => 'Product name',
                'value' => function ($model) {
                    return ($model->product->product_name ?? 'N/A');
                }
            ],
            'paymentdetails_id',
            //'address_id',
            [
                'attribute' => 'address_id',
                'label' => 'Address Details',
                'format' => 'raw',
                'value' => function ($model) {
                    $address = $model->address;
                    if (!$address) return 'N/A';
                    return "Address: {$address->address}<br>" .
                        "Dist: {$address->dist}<br>" .
                        "City: {$address->city}<br>" .
                        "State: {$address->state}<br>" .
                        "Pincode: {$address->pincode}";
                }
            ],
            'product_quantity',
            'order_date',
            [
                'label' => 'Total Paid Amount',
                'value' => function ($model) {
                    return $model->payment->total_amount ?? 'N/A';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{invoice}',
                'buttons' => [
                    'invoice' => function ($url, $model) {
                        return Html::a('🧾 Invoice', ['invoice', 'paymentdetails_id' => $model->paymentdetails_id], [
                            'target' => '_blank',
                            'class' => 'btn btn-sm btn-primary',
                            'title' => 'Download Invoice'
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>