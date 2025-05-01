<?php

use yii\helpers\Html;

$this->title = 'Invoice';
?>
<style>
    /* Page Setup for 4x6 inches */
    @page {
        size: 4in 6in;
        /* Set page size to 4x6 inches */
        margin: 0;
        /* Remove default margin */
    }

    body {
        font-family: Arial, sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .invoice-box {
        width: 100%;
        height: 100%;
        padding: 10px;
        font-size: 12px;
        /* Font size optimized for small print size */
        line-height: 18px;
        background: #fff;
    }

    .invoice-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .invoice-header img {
        width: 50px;
        /* Smaller logo for compact format */
        height: auto;
    }

    .company-name {
        font-size: 16px;
        font-weight: bold;
        color: #2d2d2d;
    }

    .invoice-box table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        /* Adjusted table font size */
    }

    .invoice-box table td {
        padding: 4px;
        /* Reduced padding for compact layout */
        vertical-align: top;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
        text-align: center;
    }

    .invoice-footer {
        margin-top: 10px;
        text-align: center;
    }

    .invoice-box .info {
        margin-bottom: 10px;
        font-size: 10px;
        /* Reduced font size for info section */
    }

    @media print {
        .no-print {
            display: none;
        }

        body {
            font-size: 12px;
            /* Ensure smaller font for print */
        }

        .invoice-box {
            padding: 10px;
            /* Reduce padding for small print area */
        }

        .invoice-box table td {
            padding: 4px;
            /* Further reduced padding */
        }

        .invoice-header img {
            width: 40px;
            /* Further reduce logo size for print */
        }

        .invoice-box .info {
            font-size: 9px;
            /* Even smaller font for print */
        }
    }
</style>

<div class="invoice-box">
    <div class="invoice-header">
        <?php
        $img = Yii::getAlias('@storageUrl') . '/images/logo.png';
        ?>
        <img src="<?php echo $img; ?>" alt="Company Logo">
        <!-- <div class="company-name">PurePetal</div> -->
    </div>

    <h2 style="text-align:center; margin-bottom: 10px;">Invoice</h2>

    <div class="info">
        <p><strong>Buyer:</strong> <?= Html::encode($buyer->name) ?> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>Phone:</strong> <?= Html::encode($buyer->phone_number) ?></p>
        <p><strong>Transaction ID:</strong> <?= Html::encode($payment->transaction_id) ?></p>
        <p><strong>Payment Method:</strong> <?= Html::encode($payment->payment_method) ?> &nbsp;&nbsp; | &nbsp;&nbsp; <strong>Status:</strong> <?= Html::encode($payment->payment_status) ?></p>
        <p><strong>Total Paid:</strong> ₹<?= Html::encode($payment->total_amount) ?></p>
    </div>

    <table>
        <tr class="heading">
            <td>Product</td>
            <td>Quantity</td>
            <td>Amount</td>
            <td>Address</td>
            <td>Order Date</td>
        </tr>

        <?php foreach ($orders as $order): ?>
            <tr class="item">
                <td><?= Html::encode($order->product->product_name) ?></td>
                <td><?= Html::encode($order->product_quantity) ?></td>
                <td>₹<?= Html::encode($order->total_amount) ?></td>
                <td>
                    <?php if ($order->address): ?>
                        <?= Html::encode("{$order->address->address}, {$order->address->city}, {$order->address->dist}, {$order->address->state} - {$order->address->pincode}") ?>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?= Yii::$app->formatter->asDatetime($order->order_date, 'php:d-M-Y') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="invoice-footer no-print">
        <button onclick="window.print()" class="btn btn-primary" style="margin-top: 10px;">🖨️ Print Invoice</button>
    </div>
</div>