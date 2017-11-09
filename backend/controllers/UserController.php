<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
        $searchModel = new UserSearch();
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

        if ($model->load(Yii::$app->request->post())) {
            $user_image = UploadedFile::getInstance($model, 'picture');
            $wechat_img = UploadedFile::getInstance($model, 'wechat_img');
            $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
            if (!empty($user_image)) {
                $user_image_ext = $user_image->getExtension();
                $userRandName = time() . rand(1000, 9999) . '.' . $user_image_ext;
                $user_img_rootPath = $img_rootPath.'head_img/';
                if (!file_exists($user_img_rootPath)) {
                    mkdir($user_img_rootPath, 0777, true);
                }
                $file->saveAs($user_img_rootPath . $userRandName);
                $model->picture = Yii::$app->params['upload_img_dir'] . 'head_img/' . $userRandName;
            }
            if (!empty($wechat_img)) {
                $wechat_image_ext = $wechat_image->getExtension();
                $wechatRandName = time() . rand(1000, 9999) . '.' . $wechat_image_ext;
                $wechat_img_rootPath = $img_rootPath.'wechat_img/';
                if (!file_exists($wechat_img_rootPath)) {
                    mkdir($wechat_img_rootPath, 0777, true);
                }
                $file->saveAs($wechat_img_rootPath . $wechatRandName);
                $model->wechat_img = Yii::$app->params['upload_img_dir'] . 'wechat_img/' . $wechatRandName;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
