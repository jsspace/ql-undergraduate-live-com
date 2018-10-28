<?php

namespace backend\controllers;

use Yii;
use backend\models\Book;
use backend\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\CourseCategory;
use yii\web\UploadedFile;
use components\helpers\QiniuUpload;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();
        $categorys = CourseCategory::hotitems();

        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];

        if ($model->load(Yii::$app->request->post())) {
            $pictrue = UploadedFile::getInstance($model, 'pictrue');
            if ($pictrue) {
                $pictrue_ext = $pictrue->getExtension();
                $pictruerandName = time() . rand(1000, 9999) . '.' . $pictrue_ext;
                $rootPath .= 'book/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $pictrue->saveAs($rootPath . $pictruerandName);
                $folder = 'book';
                $result = QiniuUpload::uploadToQiniu($pictrue, $rootPath . $pictruerandName, $folder);
                if (!empty($result)) {
                    $model->pictrue = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                    @unlink($rootPath . $pictruerandName);
                }
            }
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //没有保存成功，删除图片
                @unlink($rootPath . $pictruerandName);
                return $this->render('create', [
                    'model' => $model,
                    'categorys' => $categorys
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'categorys' => $categorys
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $categorys = CourseCategory::hotitems();

        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $old_path = $model->pictrue;
        $folder = 'book';
        if ($model->load(Yii::$app->request->post())) {
            $pictrue = UploadedFile::getInstance($model, 'pictrue');
            if ($pictrue) {
                $pictrue_ext = $pictrue->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $pictrue_ext;
                $rootPath = $rootPath . 'book/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $pictrue->saveAs($rootPath . $randName);
                $result = QiniuUpload::uploadToQiniu($pictrue, $rootPath . $randName, $folder);
                if (!empty($result)) {
                    $model->pictrue = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                    @unlink($rootPath . $randName);
                }
            } else {
                $model->pictrue = $old_path;
            }
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //没有保存成功，删除图片
                @unlink($rootPath . $randName);
                return $this->render('create', [
                    'model' => $model,
                    'categorys' => $categorys
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categorys' => $categorys
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
