<?php

namespace backend\controllers;

use Yii;
use backend\models\CoursePackage;
use backend\models\CoursePackageCategory;
use backend\models\CoursePackageSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CoursePackageController implements the CRUD actions for CoursePackage model.
 */
class CoursePackageController extends Controller
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
     * Lists all CoursePackage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoursePackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CoursePackage model.
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
     * Creates a new CoursePackage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CoursePackage();

        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];

        if ($model->load(Yii::$app->request->post())) {
            $image_list = UploadedFile::getInstance($model, 'list_pic');
            $image_home = UploadedFile::getInstance($model, 'home_pic');
            if ($image_list && $image_home) {
                $list_ext = $image_list->getExtension();
                $home_ext = $image_home->getExtension();
                $listrandName = time() . rand(1000, 9999) . '.' . $list_ext;
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $rootPath .= 'course-package/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_list->saveAs($rootPath . $listrandName);
                $image_home->saveAs($rootPath . $homerandName);
                $model->list_pic = '/'.Yii::$app->params['upload_img_dir'] . 'course-package/' . $listrandName;
                $model->home_pic = '/'.Yii::$app->params['upload_img_dir'] . 'course-package/' . $homerandName;
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

    public function actionUploadimg()
    {
        $uploadedFile = UploadedFile::getInstanceByName('upload');
        $mime = \yii\helpers\FileHelper::getMimeType($uploadedFile->tempName);
        $file = time() . "_" . $uploadedFile->name;
        $url = '/uploads/img/ckeditor/' . $file;
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $uploadPath = $rootPath . 'ckeditor/';
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0664, true);
        }
        if ($uploadedFile == null)
        {
            $message = "没有图片被上传。";
        }
        else if ($uploadedFile->size == 0)
        {
            $message = "文件大小为0。";
        } else if ($mime != "image/jpeg" && $mime != "image/png")
        {
            $message = "请上传jpeg或者png格式的图片。";
        } else if ($uploadedFile->tempName == null)
        {
            $message = "您可能试图破解我们的服务器。希望你不要这么做。";
        } else {
            $message = '';
            $uploadPath .= $file;
            $move = $uploadedFile->saveAs($uploadPath);
            if(!$move)
            {
                $message = "移动图片失败，请检查文件夹的权限！";
            }
            $funcNum = $_GET['CKEditorFuncNum'];
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        }
    }

    /**
     * Updates an existing CoursePackage model.
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
                $listrootPath = $rootPath . 'course-package/';
                if (!file_exists($listrootPath)) {
                    mkdir($listrootPath, 0777, true);
                }
                $image_list->saveAs($listrootPath . $listrandName);
                $model->list_pic = '/'.Yii::$app->params['upload_img_dir'] . 'course-package/' . $listrandName;
                @unlink(Yii::getAlias("@frontend")."/web/" . $oldlist_path);
            } else {
                $model->list_pic = $oldlist_path;
            }
            if ($image_home) {
                $home_ext = $image_home->getExtension();
                $homerandName = time() . rand(1000, 9999) . '.' . $home_ext;
                $homerootPath = $rootPath . 'course-package/';
                if (!file_exists($homerootPath)) {
                    mkdir($homerootPath, 0777, true);
                }
                $image_home->saveAs($homerootPath . $homerandName);
                $model->home_pic = '/'.Yii::$app->params['upload_img_dir'] . 'course-package/' . $homerandName;
                @unlink(Yii::getAlias("@frontend")."/web/" . $oldhome_path);
            }  else {
                $model->home_pic = $oldhome_path;
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
     * Deletes an existing CoursePackage model.
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
     * Finds the CoursePackage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CoursePackage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CoursePackage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGetcategory()
    {
        $request = Yii::$app->request->post();
        $keywords = $request['keywords'];
        $categorys= CoursePackageCategory::find()
        ->where(['like', 'name', $keywords])
        ->all();
        $data = '';
        foreach ($categorys as $category) {
            $data.='<span>'.$category->name.'</span>';
        }
        return $data;
    }
}
