<?php

namespace backend\controllers;

use common\models\OrderDetails;
use common\models\OrderDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderDetailsController implements the CRUD actions for OrderDetails model.
 */
class OrderDetailsController extends Controller
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
     * Lists all OrderDetails models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderDetailsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderDetails model.
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
     * Creates a new OrderDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new OrderDetails();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OrderDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OrderDetails model.
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
     * Finds the OrderDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OrderDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderDetails::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionInvoice($paymentdetails_id)
    {
        // echo 1;
        // die;
        $orders = OrderDetails::find()
            ->where(['paymentdetails_id' => $paymentdetails_id])
            ->with(['buyer', 'product', 'address', 'payment'])
            ->all();

        if (empty($orders)) {
            throw new NotFoundHttpException('No orders found for this payment.');
        }

        return $this->renderPartial('invoice', [
            'orders' => $orders,
            'payment' => $orders[0]->payment,
            'buyer' => $orders[0]->buyer,
        ]);
    }
}
