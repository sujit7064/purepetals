<?php

use yii\helpers\Html;
use yii\helpers\Url;

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

    <?php foreach ($grouped as $paymentId => $batch): ?>
        <div class="card mb-4">
            <div class="card-header">
                <strong>Batch No <?= Html::encode($paymentId) ?> (Payment ID: <?= Html::encode($paymentId) ?>)</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Buyer Name</th>
                            <th>Phone Number</th>
                            <th>Products & Quantities</th>
                            <th>Address</th>
                            <th>Order Date</th>
                            <th>Total Paid Amount</th>
                            <th>Invoice</th>
                            <th>Status</th> <!-- Added Status Column -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= Html::encode($batch['buyer_name']) ?></td>
                            <td><?= Html::encode($batch['phone_number']) ?></td>
                            <td>
                                <?php foreach ($batch['products'] as $product): ?>
                                    <?= Html::encode($product['product_name']) ?> (Qty: <?= Html::encode($product['quantity']) ?>)<br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php
                                if ($batch['address']) {
                                    echo "Address: " . Html::encode($batch['address']->address) . "<br>";
                                    echo "Dist: " . Html::encode($batch['address']->dist) . "<br>";
                                    echo "City: " . Html::encode($batch['address']->city) . "<br>";
                                    echo "State: " . Html::encode($batch['address']->state) . "<br>";
                                    echo "Pincode: " . Html::encode($batch['address']->pincode);
                                } else {
                                    echo "N/A";
                                }
                                ?>
                            </td>
                            <td><?= Html::encode($batch['order_date']) ?></td>
                            <td><?= Html::encode($batch['total_paid_amount']) ?></td>
                            <td>
                                <?= Html::a('🧾 Invoice', ['invoice', 'paymentdetails_id' => $paymentId], [
                                    'class' => 'btn btn-sm btn-primary',
                                    'target' => '_blank',
                                    'title' => 'Download Invoice'
                                ]) ?>
                            </td>
                            <td>
                                <?php
                                // Show status button for paymentdetails_id
                                $allStatuses = array_column($batch['status'], 'order_status');
                                if (in_array(0, $allStatuses)) { // If any Pending exists
                                    echo Html::a('Pending', ['change-status', 'paymentdetails_id' => $paymentId], [
                                        'class' => 'btn btn-warning btn-sm',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to mark ALL as Delivered?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                } else {
                                    echo Html::button('Delivered', [
                                        'class' => 'btn btn-success btn-sm',
                                        'disabled' => true,
                                    ]);
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>