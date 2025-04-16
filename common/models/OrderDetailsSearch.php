<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderDetails;

/**
 * OrderDetailsSearch represents the model behind the search form of `common\models\OrderDetails`.
 */
class OrderDetailsSearch extends OrderDetails
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'buyer_id', 'product_id', 'paymentdetails_id', 'address_id', 'order_status', 'is_delete'], 'integer'],
            [['product_quantity', 'total_amount'], 'number'],
            [['order_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = OrderDetails::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'buyer_id' => $this->buyer_id,
            'product_id' => $this->product_id,
            'paymentdetails_id' => $this->paymentdetails_id,
            'address_id' => $this->address_id,
            'product_quantity' => $this->product_quantity,
            'total_amount' => $this->total_amount,
            'order_status' => $this->order_status,
            'is_delete' => $this->is_delete,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'order_date', $this->order_date]);

        return $dataProvider;
    }
}
