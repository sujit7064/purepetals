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
                if (UploadedFile::getInstance($model, 'image') != '') {
                    $upload_image = UploadedFile::getInstance($model, 'image');
                    $baseName = str_replace(' ', '-', $upload_image->baseName);

                    $timestamp = date('Ymd-His');
                    $image = $baseName . '-' . $timestamp . '.' . $upload_image->extension;
                    $save_path = Yii::getAlias('@storage') . '/images/' . $image;

                    $upload_image->saveAs($save_path);
                    $model->image = $image;
                    if ($model->save()) {
                        return $this->redirect(['index']);
                    }
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

        // Set scenario for validation (optional image on update)
        $model->scenario = 'update';

        if ($this->request->isPost && $model->load($this->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');

            if ($image !== null) {
                // Generate a new image file name
                $path = $image->baseName . '_' . date('Y-m-d') . '.' . $image->extension;

                // Destination path (make sure @storage alias is set)
                $imgPath = Yii::getAlias('@storage') . '/images/' . $path;

                if ($image->saveAs($imgPath)) {
                    // Save the new image name in model
                    $model->image = $path;

                    // Remove the old image file if it exists
                    $oldImagePath = Yii::getAlias('@storage') . '/images/' . $oldImage;
                    if ($oldImage && file_exists($oldImagePath)) {
                        @unlink($oldImagePath);
                    }
                } else {
                    Yii::error("Failed to save uploaded image to: $imgPath", __METHOD__);
                    $model->image = $oldImage; // fallback to old image
                }
            } else {
                // No new image uploaded, keep old image
                $model->image = $oldImage;
            }

            // Save the model
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
