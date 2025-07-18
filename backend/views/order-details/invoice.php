<?php

use yii\helpers\Html;

$this->title = 'Tax Invoice';

?>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .invoice-box {
        padding: 20px;
        width: 800px;
        margin: auto;
        background: #fff;
        border: 1px solid #eee;
        position: relative;
    }

    h2 {
        text-align: center;
        margin: 0 0 10px;
    }

    .logo-right {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .logo-right img {
        width: 100px;
        /* Adjust size as needed */
        height: auto;
    }

    .section {
        margin-bottom: 15px;
    }

    .section strong {
        display: block;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    .table th,
    .table td {
        border: 1px solid #ccc;
        padding: 6px;
        text-align: center;
        font-size: 11px;
    }

    .table th {
        background: #eee;
    }

    .footer {
        font-size: 10px;
        text-align: center;
        border-top: 1px solid #ccc;
        padding-top: 10px;
    }

    .flex-row {
        display: flex;
        justify-content: space-between;
    }

    .left,
    .right {
        width: 48%;
    }

    .signature {
        margin-top: 30px;
        text-align: right;
        font-size: 11px;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
</style>

<div class="invoice-box">

    <!-- Logo in the top right corner -->
    <div class="logo-right">
        <?php $img = Yii::getAlias('@storageUrl') . '/images/logo.png'; ?>
        <img src="<?= $img ?>" alt="Company Logo">
    </div>

    <h2>Tax Invoice</h2>

    <div class="section flex-row">
        <div class="left">
            <strong>Sold By:</strong>
            <?= Html::encode($seller->name ?? 'PurePetal Enterprises') ?><br>
            GSTIN: <?= Html::encode($seller->gstin ?? '27ABCDE1234F1Z5') ?><br>
            <?= Html::encode($seller->address ?? '123 Business Park, Sector 21, Mumbai, Maharashtra - 400001') ?><br>
        </div>

        <div class="right">
            <strong>Invoice Number:</strong> <?= Html::encode($payment->invoice_number ?? 'INV' . $payment->id) ?><br>
            <strong>Invoice Date:</strong> <?= date('d-M-Y') ?><br>
            <strong>Order ID:</strong> <?= Html::encode($payment->order_reference ?? $payment->id) ?><br>
        </div>
    </div>

    <div class="section flex-row">
        <div class="left">
            <strong>Bill To:</strong>
            <?= Html::encode($buyer->name) ?><br>
            Phone: <?= Html::encode($buyer->phone_number) ?><br>
            <?php if (!empty($orders[0]->address)): ?>
                <?= Html::encode($orders[0]->address->address) ?><br>
                <?= Html::encode("{$orders[0]->address->city}, {$orders[0]->address->dist}, {$orders[0]->address->state} - {$orders[0]->address->pincode}") ?>
            <?php endif; ?>
        </div>

        <div class="right">
            <strong>Ship To:</strong>
            <?= Html::encode($buyer->name) ?><br>
            Phone: <?= Html::encode($buyer->phone_number) ?><br>
            <?php if (!empty($orders[0]->address)): ?>
                <?= Html::encode($orders[0]->address->address) ?><br>
                <?= Html::encode("{$orders[0]->address->city}, {$orders[0]->address->dist}, {$orders[0]->address->state} - {$orders[0]->address->pincode}") ?>
            <?php endif; ?>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>HSN</th>
                <th>Qty</th>
                <th>Gross Amount ₹</th>
                <th>Discount ₹</th>
                <th>Taxable Value ₹</th>
                <th>SGST ₹</th>
                <th>CGST ₹</th>
                <th>Total ₹</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= Html::encode($order->product->product_name) ?></td>
                    <td><?= Html::encode($order->product->hsn_code ?? 'NA') ?></td>
                    <td><?= Html::encode($order->product_quantity) ?></td>
                    <td><?= number_format($order->total_amount, 2) ?></td>
                    <td><?= number_format($order->discount ?? 0, 2) ?></td>
                    <td><?= number_format($order->taxable_value ?? ($order->total_amount - ($order->total_amount * 0.12)), 2) ?></td>
                    <td><?= number_format($order->sgst ?? ($order->total_amount * 0.06), 2) ?></td>
                    <td><?= number_format($order->cgst ?? ($order->total_amount * 0.06), 2) ?></td>
                    <td><?= number_format($order->total_amount, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="flex-row">
        <div class="left"></div>
        <div class="right" style="text-align:right;">
            <strong>Grand Total: ₹<?= number_format($payment->total_amount, 2) ?></strong>
        </div>
    </div>



    <div class="footer">
        Keep this invoice and original box for warranty purposes.<br>
        Returns accepted within 7 days. For support visit: <strong>www.purepetal.in</strong><br>
        This is a computer-generated invoice.
    </div>

    <div class="no-print" style="text-align:center; margin-top:10px;">
        <button onclick="window.print()">🖨️ Print Invoice</button>
    </div>
</div>