<?php

use yii\helpers\Html;

$this->title = 'Invoice';
?>
<style>
    body {
        font-family: Arial, sans-serif;
        color: #333;
    }

    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-collapse: collapse;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .invoice-footer {
        margin-top: 30px;
        text-align: center;
    }

    .invoice-box .info {
        margin-bottom: 20px;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<div class="invoice-box">
    <h2>Invoice</h2>

    <div class="info">
        <p><strong>Buyer:</strong> <?= $buyer->name ?> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>Phone:</strong> <?= $buyer->phone_number ?></p>
        <p><strong>Transaction ID:</strong> <?= $payment->transaction_id ?></p>
        <p><strong>Payment Method:</strong> <?= $payment->payment_method ?> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>Status:</strong> <?= $payment->payment_status ?></p>
        <p><strong>Total Paid:</strong> ₹<?= $payment->total_amount ?></p>
    </div>

    <table>
        <tr class="heading">
            <td>Product</td>
            <td>Quantity</td>
            <td>amount</td>
            <td>Address</td>
            <td>Order Date</td>
        </tr>

        <?php foreach ($orders as $order): ?>
            <tr class="item">
                <td><?= $order->product->product_name ?></td>
                <td><?= $order->product_quantity ?></td>
                <td><?= $order->total_amount ?></td>
                <td>
                    <?php if ($order->address): ?>
                        <?= "{$order->address->address}, {$order->address->city}, {$order->address->dist}, {$order->address->state} - {$order->address->pincode}" ?>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?= Yii::$app->formatter->asDatetime($order->order_date, 'php:d-M-Y H:i') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="invoice-footer no-print">
        <button onclick="window.print()" class="btn btn-primary" style="margin-top: 20px;">🖨️ Print Invoice</button>
    </div>
</div>