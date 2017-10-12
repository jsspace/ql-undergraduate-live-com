<?php

namespace frontend\controllers;

use Yii;
use backend\models\Course;
use backend\models\OrderGoods;
use backend\models\OrderInfo;
use backend\models\User;
use backend\models\UserSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    $userid = Yii::$app->user->id;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//             'cache' => [
//                 'class' => 'yii\filters\PageCache',
//                 'duration' => 60,
//                 'variations' => [
//                     \Yii::$app->language,
//                 ],
//             ],
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
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
    
    public function actionInfo()
    {
        return $this->render('info');
    }
    
    public function actionEdit()
    {
        $model = $this->findModel($this->$userid);
        $old_picture = $model->picture;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
            $file = UploadedFile::getInstance($model, 'picture');
             
            if ($file) {
                $ext = $file->getExtension();
                $randName = time() . rand(1000, 9999) . '.' . $ext;
                $img_rootPath .= 'head_img/';
                if (!file_exists($img_rootPath)) {
                    mkdir($img_rootPath, 0777, true);
                }
                $file->saveAs($img_rootPath . $randName);
                $model->picture = Yii::$app->params['upload_img_dir'] . 'head_img/' . $randName;
            } else {
                $model->picture = $old_picture;
            }
            
            if ($model->save()) {
                return $this->redirect(['info']);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionLmenu()
    {
        return $this->render('lmenu');
    }
    public function actionPasswordReset()
    {
        $model = $this->findModel($this->$userid);
        return $this->render('password-reset', [
            'model' => $model,
        ]);
    }
    public function actionCourse()
    {
        $orderids = OrderInfo::find()
        ->select('id')
        ->where(['user_id' => $this->$userid])
        ->asArray()
        ->all();
        $goodsids = OrderGoods::find()
        ->select('goods_id')
        ->where(['in', 'order_id', $orderids])
        ->asArray()
        ->all();
        $clist = Course::find()
        ->where(['in', 'id', $goodsids])
        ->all();
        return $this->render('course', [
            'clist' => $clist,
        ]);
    }
    public function actionFavorite()
    {
        return $this->render('favorite', [
            'flist' => $flist,
        ]);
    }
    public function actionRrders()
    {
        return $this->render('orders', [
            'olist' => $olist,
        ]);
    }
    public function actionQnas()
    {
        return $this->render('qnas', [
            'qlist' => $qlist,
        ]);
    }
    public function actionCourseReviews()
    {
        return $this->render('course-reviews', [
            'rlist' => $rlist,
        ]);
    }
    public function actionCoupon()
    {
        return $this->render('coupon', [
            'coupons' => $coupons,
        ]);
    }
}
