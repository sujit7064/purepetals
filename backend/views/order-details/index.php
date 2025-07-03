<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\OrderDetails;
use common\models\OrderDetails as ModelsOrderDetails;

$this->title = 'Order Details Batch Wise';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="order-details-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $grouped = [];

    foreach ($orderDetails as $order) {
        $grouped[$order->paymentdetails_id]['buyer_name'] = $order->buyer->name ?? 'N/A';
        $grouped[$order->paymentdetails_id]['phone_number'] = $order->buyer->phone_number ?? 'N/A';
        $grouped[$order->paymentdetails_id]['address'] = $order->address ?? null;
        $grouped[$order->paymentdetails_id]['order_date'] = $order->order_date;
        $grouped[$order->paymentdetails_id]['total_paid_amount'] = $order->payment->total_amount ?? 'N/A';
        $grouped[$order->paymentdetails_id]['products'][] = [
            'product_name' => $order->product->product_name ?? 'N/A',
            'quantity' => $order->product_quantity,
        ];
        $grouped[$order->paymentdetails_id]['status'][] = [
            'order_status' => $order->order_status,
            'id' => $order->id,
        ];
    }
    ?>

    <?php
    $currentPaymentId = null;

    foreach ($orderDetails as $order):
        // Grouping header when payment ID changes
        if ($currentPaymentId !== $order->paymentdetails_id):
            $currentPaymentId = $order->paymentdetails_id;
    ?>
            <div class="card my-4">
                <div class="card-header bg-light">
                    <strong>🧾 Payment ID: <?= Html::encode($order->paymentdetails_id) ?></strong>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-bordered mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Buyer</th>
                                <th>Phone</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Invoice</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php endif; ?>
                        <tr>
                            <td><?= Html::encode($order->buyer->name ?? 'N/A') ?></td>
                            <td><?= Html::encode($order->buyer->phone_number ?? 'N/A') ?></td>
                            <td><?= Html::encode($order->product->product_name ?? 'N/A') ?></td>
                            <td><?= Html::encode($order->product_quantity) ?></td>
                            <td>
                                <?php
                                if ($order->address) {
                                    echo "Address: " . Html::encode($order->address->address) . "<br>";
                                    echo "Dist: " . Html::encode($order->address->dist) . "<br>";
                                    echo "City: " . Html::encode($order->address->city) . "<br>";
                                    echo "State: " . Html::encode($order->address->state) . "<br>";
                                    echo "Pincode: " . Html::encode($order->address->pincode);
                                } else {
                                    echo "N/A";
                                }
                                ?>
                            </td>
                            <td><?= Html::encode($order->order_date) ?></td>
                            <td><?= Html::encode($order->total_amount) ?></td>
                            <td>
                                <?= Html::a('Invoice', ['invoice', 'paymentdetails_id' => $order->paymentdetails_id], [
                                    'class' => 'btn btn-sm btn-secondary',
                                    'target' => '_blank'
                                ]) ?>
                            </td>
                            <td>
                                <strong><?= \common\models\OrderDetails::STATUSES[$order->order_status] ?? 'Unknown' ?></strong><br>
                                <?= Html::beginForm(['change-status-single', 'id' => $order->id], 'post', ['style' => 'margin-top:5px']) ?>
                                <?= Html::dropDownList('status', null, \common\models\OrderDetails::STATUSES, [
                                    'class' => 'form-control form-control-sm',
                                    'prompt' => 'Change status'
                                ]) ?>
                                <?= Html::submitButton('Update', ['class' => 'btn btn-primary btn-sm mt-1']) ?>
                                <?= Html::endForm() ?>
                            </td>
                        </tr>
                        <?php
                        // If next order is different payment or end of list, close the table and card
                        $nextOrder = next($orderDetails);
                        if (!$nextOrder || $nextOrder->paymentdetails_id !== $currentPaymentId):
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php
                        endif;
                    endforeach;
    ?>

</div>