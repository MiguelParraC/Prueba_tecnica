<?php

namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\ProductsPool;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use DateTime;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
     * Lists all Category models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        $model->view = 'create';
        
        $this->LoadDataForm($model);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate()) {
                    
                    // Set the user who created the category
                    $model->who_created = \Yii::$app->user->id;
                    $model->created_at = date('Y-m-d H:i:s');   
                    // Set the user who updated the category
                    $model->who_updated = \Yii::$app->user->id;
                    $model->updated_at = date('Y-m-d H:i:s');


                    $model->save();
                    return $this->redirect(['index']);
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

    public function LoadDataForm($model)
    {
        $ppool = new ProductsPool();
        $model->list_status = $ppool->getStatus();
        // load who
        $model->name_who_created = \Yii::$app->user->id;
        $model->name_who_updated = \Yii::$app->user->id;
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->view = 'update';

        $this->LoadDataForm($model);

        if ($this->request->isPost && $model->load($this->request->post())) {

            if ($model->validate()) {
                // Set the user who updated the category
                $model->who_updated = \Yii::$app->user->id;
                $model->updated_at = date('Y-m-d H:i:s');

                // If status is not set, default to active
                if ($model->status === null) {
                    $model->status = 1; // Active
                }

                 $model->save();
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

           
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        
        $model = $this->findModel($id);
        $model->status = 0; // Set status to inactive instead of deleting
        $model->who_updated = \Yii::$app->user->id;
        $model->updated_at = date('Y-m-d H:i:s');
        if($model->save()) {
            Yii::$app->session->setFlash('warning', 'La categoría no puede ser eliminada, por lo tanto se inactiva.');
            $bitacora = new \frontend\models\Bitacora();
            $bitacora->accion = 4; // Acción de eliminación
            $list_action = $bitacora->getActions();
            $bitacora->user = \Yii::$app->user->id;
            $bitacora->created_at = date('Y-m-d H:i:s');
            $bitacora->descripcion = 'El Usuario ' . \Yii::$app->user->identity->username . ' eliminó la categoría: ' . $model->name . ' el ' . date('Y-m-d H:i:s');
            $bitacora->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
