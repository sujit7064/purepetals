<?php

use yii\helpers\Html;

$this->title = 'Invoice';

?>
<style>
    @page {
        size: 4in 6in;
        margin: 0;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .invoice-box {
        padding: 10px;
        width: 100%;
        height: 100%;
        background: #fff;
    }

    .seller-info,
    .info,
    .shipping-info,
    .invoice-meta,
    .invoice-footer {
        margin-bottom: 10px;
    }

    .seller-info {
        text-align: center;
        font-size: 10px;
    }

    .invoice-box table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    .invoice-box table td {
        padding: 4px;
        vertical-align: top;
        text-align: center;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-footer {
        font-size: 9px;
        text-align: center;
        border-top: 1px dashed #aaa;
        padding-top: 5px;
    }

    h2 {
        text-align: center;
        margin: 8px 0;
    }

    .invoice-header img {
        display: block;
        margin: 0 auto;
        width: 40px;
    }

    @media print {
        .no-print {
            display: none;
        }

        body {
            font-size: 10px;
        }
    }
</style>

<div class="invoice-box">
    <div class="invoice-header">
        <?php $img = Yii::getAlias('@storageUrl') . '/images/logo.png'; ?>
        <img src="<?= $img ?>" alt="Company Logo">
    </div>

    <div class="seller-info">
        <strong>PurePetal Enterprises</strong><br>
        GSTIN: 27ABCDE1234F1Z5<br>
        123 Business Park, Sector 21, Mumbai, Maharashtra - 400001<br>
        Email: support@purepetal.in | Phone: +91-9000000000
    </div>

    <h2>Invoice</h2>

    <div class="invoice-meta">
        <p><strong>Invoice No:</strong> <?= Html::encode($payment->invoice_number ?? 'INV' . $payment->id) ?> &nbsp; | &nbsp;
            <strong>Invoice Date:</strong> <?= date('d-M-Y') ?>
        </p>
        <p><strong>Order ID:</strong> <?= Html::encode($payment->order_reference ?? $payment->id) ?></p>
    </div>

    <div class="info">
        <p><strong>Buyer:</strong> <?= Html::encode($buyer->name) ?> &nbsp; | &nbsp;
            <strong>Phone:</strong> <?= Html::encode($buyer->phone_number) ?>
        </p>
        <p><strong>Payment Method:</strong> <?= Html::encode($payment->payment_method) ?> &nbsp; | &nbsp;
            <strong>Status:</strong> <?= Html::encode($payment->payment_status) ?>
        </p>
    </div>

    <div class="shipping-info">
        <strong>Shipping Address:</strong><br>
        <?= Html::encode($buyer->name) ?><br>
        <?php if (!empty($orders[0]->address)): ?>
            <?= Html::encode($orders[0]->address->address) ?><br>
            <?= Html::encode("{$orders[0]->address->city}, {$orders[0]->address->dist}, {$orders[0]->address->state} - {$orders[0]->address->pincode}") ?><br>
            Phone: <?= Html::encode($buyer->phone_number) ?>
        <?php else: ?>
            Address not available
        <?php endif; ?>
    </div>

    <table>
        <tr class="heading">
            <td>Product</td>
            <td>Qty</td>
            <td>Unit Price</td>
            <td>Total</td>
        </tr>

        <?php foreach ($orders as $order): ?>
            <tr class="item">
                <td><?= Html::encode($order->product->product_name) ?></td>
                <td><?= Html::encode($order->product_quantity) ?></td>
                <td>₹<?= Html::encode(number_format($order->total_amount / $order->product_quantity, 2)) ?></td>
                <td>₹<?= Html::encode(number_format($order->total_amount, 2)) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="info" style="text-align:right; font-weight:bold; margin-top:8px;">
        Total Paid: ₹<?= Html::encode(number_format($payment->total_amount, 2)) ?>
    </div>

    <div class="invoice-footer">
        This is a computer-generated invoice. No signature required.<br>
        Returns accepted within 7 days of delivery. Visit <strong>www.purepetal.in</strong> for support.
    </div>

    <div class="invoice-footer no-print">
        <button onclick="window.print()" class="btn btn-primary" style="margin-top: 8px;">🖨️ Print Invoice</button>
    </div>
</div>