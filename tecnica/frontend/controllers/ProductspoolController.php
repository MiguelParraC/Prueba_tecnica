<?php

namespace frontend\controllers;

use frontend\models\ProductsPool;
use frontend\models\ProductspoolSearch;
use frontend\models\Bitacora;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use DateTime;


/**
 * ProductspoolController implements the CRUD actions for ProductsPool model.
 */
class ProductspoolController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'update', 'create'],
                    'rules' => [
                        [
                            'actions' => ['index', 'update', 'create'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
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
     * Lists all ProductsPool models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductspoolSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductsPool model.
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
     * Creates a new ProductsPool model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductsPool();
        $model->model_action = 'create';
        $this->LoadDataForm($model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if ($model->validate()) {
                    // Estableciendo tiempo de creación
                    $TimeZone = "America/Mexico_City";
                    $fecha_objeto = new DateTime();
                    $fecha_objeto->setTimezone(new \DateTimeZone($TimeZone));
                    $fecha_update = $fecha_objeto->format("Y-m-d H:i:s");
                    // $fecha_archivos = $fecha_objeto->format("Y-m-d-H-i-s");
                    // $fecha_hoy = $fecha_objeto->format('Y-m-d');

                    $model->who_created = Yii::$app->user->identity->id;
                    $model->created_at = $fecha_update;
                    $model->who_updated = Yii::$app->user->identity->id;
                    $model->updated_at = $fecha_update;

                    if ($model->stock == 0) {
                        $model->status = 2;
                    }

                    $bitacora = new Bitacora();
                    $bitacora->accion = 0;
                    $list_action = $bitacora->getActions();
                    $bitacora->user = Yii::$app->user->identity->id;
                    $bitacora->created_at = $fecha_update;
                    $bitacora->descripcion = 'El Usuario ' . Yii::$app->user->identity->username . '. Realizó: ' . $list_action[$bitacora->accion] . ', Del producto: ' . $model->name . '. El ' . $fecha_update;
                    $bitacora->save();

                    if ($model->save()) {
                        return $this->redirect(['index']);
                    } else {
                        return $this->render('create', [
                            'model' => $model,
                            'error' => 'Error al guardar los datos',
                        ]);
                    }
                } else {
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
     * Updates an existing ProductsPool model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->model_action = 'update';
        $this->LoadDataForm($model);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validate()) {
                // Estableciendo tiempo de creación
                $TimeZone = "America/Mexico_City";
                $fecha_objeto = new DateTime();
                $fecha_objeto->setTimezone(new \DateTimeZone($TimeZone));
                $fecha_update = $fecha_objeto->format("Y-m-d H:i:s");
                // $fecha_archivos = $fecha_objeto->format("Y-m-d-H-i-s");
                // $fecha_hoy = $fecha_objeto->format('Y-m-d');

                if ($model->stock == 0) {
                    $model->status = 2;
                }

                $model->who_updated = Yii::$app->user->identity->id;
                $model->updated_at = $fecha_update;
                $bitacora = new Bitacora();
                // decidiendo Si se realizó aumento o no del producto
                if ($model->aux_stock  < $model->stock) {
                    $bitacora->accion = 1;
                } else {
                    $bitacora->accion = 3;
                }

                $list_action = $bitacora->getActions();

                $bitacora->user = Yii::$app->user->identity->id;
                $bitacora->created_at = $fecha_update;
                $bitacora->descripcion = 'El Usuario ' . Yii::$app->user->identity->username . '. Realizó: ' . $list_action[$bitacora->accion] . ', Del producto: ' . $model->name . '. El ' . $fecha_update;
                $bitacora->save();

                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductsPool model.
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
     * Finds the ProductsPool model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ProductsPool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductsPool::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function LoadDataForm(&$model)
    {
        $model->list_status = [0 => 'Inactivo', 1 => 'Activo', 2 => 'Agotado'];
        $model->list_names = ArrayHelper::map(ProductsPool::find()->all(), 'id', 'name');
        $model->list_action = [0 => 'Creado', 1 => 'Entrada', 2 => 'Salida'];
        $category = new \frontend\models\Category();
        $model->list_categories = $category->getListCategories();
        if ($model->model_action != 'create') {
            $model->name_user_create = $model->whoCreated->username;
            $model->name_user_updated = $model->whoUpdated->username;
            $model->aux_stock = $model->stock;
        }
    }
}
