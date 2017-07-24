<?php

namespace backend\controllers;

use Yii;
use backend\models\Course;
use backend\models\CourseCategory;
use backend\models\CourseSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
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
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];

        if ($model->load(Yii::$app->request->post())) {
            $image_list = UploadedFile::getInstance($model, 'list_pic');
            $image_home = UploadedFile::getInstance($model, 'home_pic');
            if ($image_list && $image_home) {
                $list_ext = $image_list->getExtension();
                $home_ext = $image_home->getExtension();
                $listrandName = time() . rand(1000, 9999) . '.' . $list_ext;
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $rootPath .= 'course/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_list->saveAs($rootPath . $listrandName);
                $image_home->saveAs($rootPath . $homerandName);
                $model->list_pic = Yii::$app->params['upload_img_dir'] . 'course/' . $listrandName;
                $model->home_pic = Yii::$app->params['upload_img_dir'] . 'course/' . $homerandName;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //没有保存成功，删除图片
                @unlink($rootPath . $listrandName);
                @unlink($rootPath . $homerandName);
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $oldlist_path = $model->list_pic;
        $oldhome_path = $model->home_pic;
        if ($model->load(Yii::$app->request->post())) {
            $image_list = UploadedFile::getInstance($model, 'list_pic');
            $image_home = UploadedFile::getInstance($model, 'home_pic');
            if ($image_list) {
                $list_ext = $image_list->getExtension();
                $listrandName = time() . rand(1000, 9999) . '.' . $list_ext;
                $rootPath .= 'course/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_list->saveAs($rootPath . $listrandName);
                $model->list_pic = Yii::$app->params['upload_img_dir'] . 'course/' . $listrandName;
                @unlink(Yii::getAlias("@frontend")."/web/" . $oldlist_path);
            }
            if ($image_home) {
                $home_ext = $image_home->getExtension();
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $rootPath .= 'course/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_home->saveAs($rootPath . $homerandName);
                $model->home_pic = Yii::$app->params['upload_img_dir'] . 'course/' . $homerandName;
                @unlink(Yii::getAlias("@frontend")."/web/" . $oldhome_path);
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                //没有保存成功，删除图片
                @unlink($rootPath . $listrandName);
                @unlink($rootPath . $homerandName);
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Course model.
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
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetcategory()
    {
        $request = Yii::$app->request->post();
        $keywords = $request['keywords'];
        $categorys= CourseCategory::find()
        ->where(['like', 'name', $keywords])
        ->all();
        $data = '';
        foreach ($categorys as $category) {
            $data.='<span>'.$category->name.'</span>';
        }
        return $data;
    }
}
