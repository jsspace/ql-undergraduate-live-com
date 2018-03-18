<?php

namespace backend\controllers;

use Yii;
use backend\models\HotCategory;
use backend\models\HotCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * HotCategoryController implements the CRUD actions for HotCategory model.
 */
class HotCategoryController extends Controller
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
        ];
    }

    /**
     * Lists all HotCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HotCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HotCategory model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HotCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HotCategory();
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];

        if ($model->load(Yii::$app->request->post())) {
            $image_icon = UploadedFile::getInstance($model, 'icon');
            if ($image_icon) {
                $icon_ext = $image_icon->getExtension();
                $iconrandName = time() . rand(1000, 9999) . '.' . $icon_ext;
                $rootPath .= 'hot-course/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_icon->saveAs($rootPath . $iconrandName);
                $model->icon = '/'.Yii::$app->params['upload_img_dir'] . 'hot-course/' . $iconrandName;
            }
            if ($model->save(false)) {
                return $this->redirect('index');
            } else {
                //没有保存成功，删除图片
                @unlink($rootPath . $iconrandName);
                return $this->render('create', ['model' => $model]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HotCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $old_path = $model->icon;
        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'icon');
            if ($image) {
                $image_ext = $image->getExtension();
                $imagerandName = time() . rand(1000, 9999) . '.' . $image_ext;
                $imagerootPath = $rootPath . 'hot-course/';
                if (!file_exists($imagerootPath)) {
                    mkdir($imagerootPath, 0777, true);
                }
                $image->saveAs($imagerootPath . $imagerandName);
                $model->icon = '/'.Yii::$app->params['upload_img_dir'] . 'hot-course/' . $imagerandName;
                @unlink(Yii::getAlias("@frontend")."/web/" . $old_path);
            } else {
                $model->icon = $old_path;
            }
            if ($model->save(false)) {
                return $this->redirect('index');
            } else {
                //没有保存成功，删除图片
                @unlink($rootPath . $imagerandName);
                return $this->render('create', ['model' => $model]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing HotCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HotCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HotCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HotCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
