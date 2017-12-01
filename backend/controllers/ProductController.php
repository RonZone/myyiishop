<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\Brand;
use common\models\Category;
use common\models\ProductImage;
use common\models\ProductType;
use common\models\Status;

use common\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadFile;
use backend\widgets\image\RemoveAction;
use backend\widgets\image\UploadAction;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => UploadAction::className(),
                'upload' => 'upload',
            ],
            'remove' => [
                'class' => RemoveAction::className(),
                'uploadDir' => '@frontend/web/upload',
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
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
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->loadDefaultValues();
        //var_dump($model->type);exit;
        if ($model->load(Yii::$app->request->post())) {
            $model->type = ProductType::arrayToInt($model->type);
            if ($model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            //var_dump($model->type);exit;
            $model->type = ProductType::arrayToInt($model->type);
            if ($model->save()) {
                if (isset(Yii::$app->request->post()['imageSort'])) {
                    foreach (Yii::$app->request->post()['imageSort'] as $key => $sortOrder) {
                        ProductImage::updateAll(['sort_order' => $sortOrder], ['id' => $key]);
                    }
                }

                $productImage = ProductImage::find()->where(['product_id' => $id])->orderBy(['sort_order' => SORT_ASC])->one();
                if ($productImage) {
                    $model->image = $productImage->iamge;
                    $model->thumb = $productImage->thumb;
                    $model->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
            
        }

        $model->type = ProductType::intToArray($model->type);
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
