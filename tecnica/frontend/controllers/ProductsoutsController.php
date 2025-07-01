<?php

namespace frontend\controllers;

use frontend\models\ProductsOuts;
use frontend\models\ProductsoutsSearch;
use frontend\models\ProductsPool;
use frontend\models\ProductsSales;
use frontend\models\Bitacora;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use DateTime;



/**
 * ProductsoutsController implements the CRUD actions for ProductsOuts model.
 */
class ProductsoutsController extends Controller
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
     * Lists all ProductsOuts models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductsoutsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsOuts model.
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
     * Creates a new ProductsOuts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductsOuts();
        $this->LoadDataForm($model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                // Estableciendo tiempo de creación
                $TimeZone = "America/Mexico_City";
                $fecha_objeto = new DateTime();
                $fecha_objeto->setTimezone(new \DateTimeZone($TimeZone));
                $fecha_update = $fecha_objeto->format("Y-m-d H:i:s");

                $model->who_created = Yii::$app->user->identity->id;
                $model->created_at = $fecha_update;
                if ($model->save()) {
                    // Guardando lo productos seleccionados
                    if (isset($model->sales_products)) {
                        foreach ($model->sales_products as $key => $value) {
                            $model_sales = new ProductsSales();
                            $model_sales->poduct_out_id = $model->id;
                            $model_sales->product_id = $value['product'];
                            $model_sales->quantity = $value['quantity'];
                            // Consultando el precio del producto
                            $model_productpool = ProductsPool::findOne($value['product']);
                            // Guardando el precio del producto en el momento para llevar un historial de ventas
                            $model_productpool->stock = $model_productpool->stock - $value['quantity'];
                            if($model_productpool->stock == 0){
                                $model_productpool->status = 2;
                            }
                            if (!$model_productpool->save()) {
                                $model_productpool->errors;
                            }
                            $model_sales->price = $model_productpool->price;
                            if (!$model_sales->save()) {
                                $model_sales->errors;
                            }
                            $bitacora = new Bitacora();
                            $list_action = $bitacora->getActions();
                            $bitacora->accion = 2;
                            $bitacora->user = Yii::$app->user->identity->id;
                            $bitacora->created_at = $fecha_update;
                            $bitacora->descripcion = 'El Usuario ' . Yii::$app->user->identity->username . '. Realizó: ' . $list_action[2] . ', Del producto: '.$model_productpool->name . '. El ' . $fecha_update;
                            $bitacora->save();
                        }
                    } else {
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                    return $this->redirect(['index']);
                } else {
                    $model->errors;
                    return $this->render('create', [
                        'model' => $model,
                    ]);
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
     * Updates an existing ProductsOuts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->LoadDataForm($model);

        if ($this->request->isPost && $model->load($this->request->post())) {

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductsOuts model.
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
     * Finds the ProductsOuts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductsOuts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsOuts::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function LoadDataForm(&$model)
    {
        $model->list_products = ArrayHelper::map(ProductsPool::find()->where(['status' => 1])->all(), 'id', 'name');
        $model->count_products = count($model->list_products);
        $model->list_action = [0 => 'Creado', 1 => 'Entrada', 2 => 'Salida'];
        // consultando product sales para cargar al formulario
        if (isset($model->id)) {
            $model_sales = ProductsSales::find()->where(['poduct_out_id'  => $model->id])->all();
            // cargando al vector para mostrar en el formulario
            if ($model_sales) {
                foreach ($model_sales as $sale) {
                    $model->sales_products[] = ['product' => $sale->product_id, 'quantity' => $sale->quantity];
                }
            }
        }
    }

    // función para buscar el stock del producto
    public function actionGetstock($product_element)
    {
        $stock = ProductsPool::find()->where(['id' => $product_element])->one();
        return json_encode(['stock' => $stock->stock]);
    }
}
