<?php

namespace backend\controllers;

use common\models\Product;
use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->scenario = 'create';

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                // Handle single image upload
                if (UploadedFile::getInstance($model, 'image') !== null) {
                    $upload_image = UploadedFile::getInstance($model, 'image');
                    $baseName = str_replace(' ', '-', $upload_image->baseName);
                    $timestamp = date('Ymd-His');
                    $image = $baseName . '-' . $timestamp . '.' . $upload_image->extension;
                    $save_path = Yii::getAlias('@storage') . '/images/' . $image;
                    $upload_image->saveAs($save_path);
                    $model->image = $image;
                }

                // Handle multiple images upload
                $multipleImages = UploadedFile::getInstances($model, 'multiple_image');
                $multipleImageNames = [];

                if (!empty($multipleImages)) {
                    foreach ($multipleImages as $file) {
                        $baseName = str_replace(' ', '-', $file->baseName);
                        $timestamp = date('Ymd-His') . '-' . rand(100, 999);
                        $filename = $baseName . '-' . $timestamp . '.' . $file->extension;
                        $filePath = Yii::getAlias('@storage') . '/images/' . $filename;

                        if ($file->saveAs($filePath)) {
                            $multipleImageNames[] = $filename;
                        }
                    }
                    // Save filenames as JSON or comma-separated string
                    $model->multiple_image = json_encode($multipleImageNames); // or implode(',', $multipleImageNames);
                }

                // Save model
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;
        $oldMultipleImages = $model->multiple_image;

        $model->scenario = 'update';

        if ($this->request->isPost && $model->load($this->request->post())) {

            // --- Handle Single Image ---
            $image = UploadedFile::getInstance($model, 'image');
            if ($image !== null) {
                $path = str_replace(' ', '-', $image->baseName) . '-' . date('Ymd-His') . '.' . $image->extension;
                $imgPath = Yii::getAlias('@storage') . '/images/' . $path;

                if ($image->saveAs($imgPath)) {
                    $model->image = $path;

                    // Remove old image
                    $oldImagePath = Yii::getAlias('@storage') . '/images/' . $oldImage;
                    if ($oldImage && file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                } else {
                    $model->image = $oldImage;
                }
            } else {
                $model->image = $oldImage;
            }

            // --- Handle Multiple Images ---
            $multipleImages = UploadedFile::getInstances($model, 'multiple_image');
            $multipleImageNames = [];

            if (!empty($multipleImages)) {
                foreach ($multipleImages as $file) {
                    $baseName = str_replace(' ', '-', $file->baseName);
                    $timestamp = date('Ymd-His') . '-' . rand(100, 999);
                    $filename = $baseName . '-' . $timestamp . '.' . $file->extension;
                    $filePath = Yii::getAlias('@storage') . '/images/' . $filename;

                    if ($file->saveAs($filePath)) {
                        $multipleImageNames[] = $filename;
                    }
                }

                // Save new images list
                $model->multiple_image = json_encode($multipleImageNames);
            } else {
                // Keep old multiple image JSON
                $model->multiple_image = $oldMultipleImages;
            }

            if ($model->save()) {
                return $this->redirect(['index', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }



    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
