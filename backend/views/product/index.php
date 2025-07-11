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
            'price',
            'quantity',
            'description',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>