<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\TeacherSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AuthAssignment;
use yii\web\UploadedFile;

/**
 * TeacherController implements the CRUD actions for User model.
 */
class TeacherController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TeacherSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $model->status = 10;
        if ($model->load(Yii::$app->request->post())) {
            $image_picture = UploadedFile::getInstance($model, 'picture');
            if ($image_picture) {
                $ext = $image_picture->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $rootPath .= 'teacher/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_picture->saveAs($rootPath . $image_picture);
                $model->picture = '/'.Yii::$app->params['upload_img_dir'] . 'teacher/' . $image_picture;
            }
            if ($model->save(false)) {
                $role = new AuthAssignment();
                $role->item_name = 'teacher';
                $role->user_id = $model->id;
                $role->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
             @unlink($rootPath . $image_picture);
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $oldpicture_path = $model->picture;
        if ($model->load(Yii::$app->request->post())) {
            $image_picture = UploadedFile::getInstance($model, 'picture');
            if ($image_picture) {
                $ext = $image_picture->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $rootPath = $rootPath . 'teacher/';
                if (!file_exists($rootPath)) {
                    mkdir($rootPath, 0777, true);
                }
                $image_picture->saveAs($rootPath . $randName);
                $model->picture = '/'.Yii::$app->params['upload_img_dir'] . 'teacher/' . $randName;
                $model->save(false);
                @unlink(Yii::getAlias("@frontend")."/web/" . $oldpicture_path);
            } else {
                $model->picture = $oldpicture_path;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
