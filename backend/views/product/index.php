<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'category_id',
            'product_name',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => function ($model) {
                    $img = Yii::getAlias('@storageUrl') . '/images/' . $model->image;
                    $placeholder = Yii::getAlias('@web') . '/images/no_image.jpg';

                    $fileContent = @file_get_contents(Yii::getAlias('@storageUrl') . '/images/' . $model->image);

                    if ($fileContent !== false) {

                        return '<img src="' . $img . '" width="100" height="100">';
                    } else {

                        return '<img src="' . $placeholder . '" width="100" height="100">';
                    }
                }
            ],
            [
                'attribute' => 'cut_price',
                'label' => 'Cut Price',
            ],
            'price',
            'quantity',
            'description',
            [
                'attribute' => 'multiple_image',
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    $images = [];

                    // Decode the JSON string into an array
                    if (!empty($model->multiple_image)) {
                        $images = json_decode($model->multiple_image, true);
                    }

                    // Display each image
                    if (is_array($images)) {
                        foreach ($images as $img) {
                            $img = trim($img);
                            $url = Yii::getAlias('@storageUrl') . '/images/' . $img;

                            $html .= \yii\helpers\Html::img($url, [
                                'width' => '60',
                                'height' => '60',
                                'style' => 'margin: 3px; border-radius: 4px; border: 1px solid #ccc;',
                            ]);
                        }
                    }

                    return $html ?: \yii\helpers\Html::tag('span', 'No Images');
                }
            ],

            [
                'attribute' => 'details',
                'format' => 'raw',
                'value' => function ($model) {
                    if (empty($model->details)) return '<em>No Details</em>';

                    $items = [];
                    $pairs = explode(',', $model->details);
                    foreach ($pairs as $pair) {
                        $parts = explode(':', $pair, 2);
                        if (count($parts) === 2) {
                            $label = trim($parts[0]);
                            $value = trim($parts[1]);
                            $items[] = "<strong>{$label}:</strong> {$value}";
                        }
                    }
                    return implode('<br>', $items);
                }
            ],


            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>