<?php

namespace backend\controllers;

use Yii;
use backend\models\CourseCategory;
use backend\models\CourseCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use components\helpers\QiniuUpload;

/**
 * CourseCategoryController implements the CRUD actions for CourseCategory model.
 */
class CourseCategoryController extends Controller
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
     * Lists all CourseCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseCategory model.
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
     * Creates a new CourseCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseCategory();

        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];

        if ($model->load(Yii::$app->request->post())) {
            $postData = Yii::$app->request->post();
            $tutor = $postData['CourseCategory']['tutor'];
            $model->tutor = implode(',', $tutor);
            $image_list = UploadedFile::getInstance($model, 'list_icon');
            $image_home = UploadedFile::getInstance($model, 'detail_icon');
            $image_home_left = UploadedFile::getInstance($model, 'home_icon');
            $folder = 'course-category';
            $rootPath .= 'course-category/';
            if (!file_exists($rootPath)) {
                mkdir($rootPath, 0777, true);
            }
            if ($image_list) {
                $list_ext = $image_list->getExtension();
                $listrandName = time() . rand(1000, 9999) . '.' . $list_ext;
                $image_list->saveAs($rootPath . $listrandName);
                $result = QiniuUpload::uploadToQiniu($image_list, $rootPath . $listrandName, $folder);
                if (!empty($result)) {
                    $model->list_icon = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                } else {
                    @unlink($rootPath . $listrandName);
                }
            }
            if ($image_home) {
                $home_ext = $image_home->getExtension();
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $image_home->saveAs($rootPath . $homerandName);
                $result = QiniuUpload::uploadToQiniu($image_home, $rootPath . $homerandName, $folder);
                if (!empty($result)) {
                    $model->detail_icon = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                } else {
                    @unlink($rootPath . $homerandName);
                }
            }
            if ($image_home_left) {
                $home_left_ext = $image_home_left->getExtension();
                $home_left_randName = time() . rand(1000, 9999) . '.' . $home_left_ext;
                $image_home_left->saveAs($rootPath . $home_left_randName);
                $result = QiniuUpload::uploadToQiniu($image_home_left, $rootPath . $home_left_randName, $folder);
                if (!empty($result)) {
                    $model->home_icon = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                } else {
                    @unlink($rootPath . $image_home_left);
                }
            }
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //没有保存成功，删除图片
                return $this->render('create', [
                    'model' => $model
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing CourseCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $oldlist_path = $model->list_icon;
        $oldhome_path = $model->detail_icon;
        $oldhomeleft_path = $model->home_icon;
        $folder = 'course-category';
        $rootPath .= 'course-category/';
        if (!file_exists($rootPath)) {
            mkdir($rootPath, 0777, true);
        }
        if ($model->load(Yii::$app->request->post())) {
            $postData = Yii::$app->request->post();
            $tutor = $postData['CourseCategory']['tutor'];
            $model->tutor = implode(',', $tutor);
            $image_list = UploadedFile::getInstance($model, 'list_icon');
            $image_home = UploadedFile::getInstance($model, 'detail_icon');
            $image_home_left = UploadedFile::getInstance($model, 'home_icon');
            if ($image_list) {
                $list_ext = $image_list->getExtension();
                $listrandName = time() . rand(1000, 9999) . '.' . $list_ext;
                $image_list->saveAs($rootPath . $listrandName);
                $result = QiniuUpload::uploadToQiniu($image_list, $rootPath . $listrandName, $folder);
                if (!empty($result)) {
                    $model->list_icon = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                } else {
                    @unlink($rootPath . $listrandName);
                }
            } else {
                $model->list_icon = $oldlist_path;
            }
            if ($image_home) {
                $home_ext = $image_home->getExtension();
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $image_home->saveAs($rootPath . $homerandName);
                $result = QiniuUpload::uploadToQiniu($image_home, $rootPath . $homerandName, $folder);
                if (!empty($result)) {
                    $model->detail_icon = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                } else {
                    @unlink($rootPath . $homerandName);
                }
            } else {
                $model->detail_icon = $oldhome_path;
            }
            if ($image_home_left) {
                $home_ext = $image_home_left->getExtension();
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $image_home_left->saveAs($rootPath . $homerandName);
                $result = QiniuUpload::uploadToQiniu($image_home_left, $rootPath . $homerandName, $folder);
                if (!empty($result)) {
                    $model->home_icon = Yii::$app->params['get_source_host'].'/'.$result[0]['key'];
                } else {
                    @unlink($rootPath . $image_home_left);
                }
            } else {
                $model->home_icon = $oldhomeleft_path;
            }
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model
            ]);
        }
    }

    /**
     * Deletes an existing CourseCategory model.
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
     * Finds the CourseCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CourseCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
