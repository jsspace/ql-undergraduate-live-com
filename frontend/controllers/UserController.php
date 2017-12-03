<?php

namespace frontend\controllers;

use Yii;
use backend\models\Course;
use backend\models\OrderGoods;
use backend\models\OrderInfo;
use backend\models\User;
use backend\models\UserSearch;
use backend\models\Collection;
use backend\models\CourseComent;
use backend\models\Coupon;
use backend\models\Quas;
use backend\models\Coin;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        $model = $this->findModel(Yii::$app->user->id);
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
        $model = $this->findModel(Yii::$app->user->id);
        
        //$model->password_hash = Yii::$app->security->generatePasswordHash($password);
        
        return $this->render('password-reset', [
            'model' => $model,
        ]);
    }
    
    public function actionCourse()
    {
        $orderids = OrderInfo::find()
        ->select('course_ids')
        ->where(['user_id' => Yii::$app->user->id])
        ->asArray()
        ->all();
        $goodsids = '';
        foreach ($orderids as $key => $orderid) {
            $goodsids.=$orderid['course_ids'].',';
        }
        $goodsid_arr = explode(',', $goodsids);
        $clist = Course::find()
        ->where(['in', 'id', $goodsid_arr])
        ->all();
        return $this->render('course', [
            'clist' => $clist,
        ]);
    }
    public function actionFavorite()
    {
        $collections = Collection::find()
        ->where(['userid' => Yii::$app->user->id])
        ->all();
        $courseid = '';
        foreach ($collections as $key => $collection) {
            $courseid.=$collection->courseid.',';
        }
        $courseid_arr = explode(',', $courseid);
        $flist = Course::find()
        ->where(['in', 'id', $courseid_arr])
        ->all();
        return $this->render('favorite', [
            'flist' => $flist,
        ]);
    }
    public function actionUnfavorite()
    {
        $post = Yii::$app->request->post();
        $course_id = $post['course_id'];
        $favor = $post['favor'];
        if ($favor == 1) {
            Collection::find()
            ->where(['and',['userid' => Yii::$app->user->id], ['courseid' => $course_id]])
            ->one()
            ->delete();
        } else {
            $collection = new Collection();
            $collection->userid = Yii::$app->user->id;
            $collection->courseid = $course_id;
            $collection->save();
        }
        return 'success';
    }
    public function actionOrders()
    {
        //所有订单
        $all_orders = OrderInfo::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->orderBy('add_time desc')
        ->all();
        //等待付款
        return $this->render('orders', [
            'all_orders' => $all_orders
        ]);
    }
    public function actionQnas()
    {
        $all_quas = Quas::find()
        ->where(['student_id' => Yii::$app->user->id])
        ->orderBy('question_time desc')
        ->all();
        return $this->render('qnas', [
            'qlist' => $all_quas,
        ]);
    }
    public function actionCourseReviews()
    {
        $coments = CourseComent::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->all();
        return $this->render('course-reviews', [
            'coments' => $coments,
        ]);
    }
    public function actionCoupon()
    {
        $coupons = Coupon::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->all();
        return $this->render('coupon', [
            'coupons' => $coupons,
        ]);
    }
    public function actionCoin()
    {
        $coins = Coin::find()
        ->where(['userid' => Yii::$app->user->id])
        ->orderBy('id desc')
        ->all();
        return $this->render('coin', [
            'coins' => $coins,
        ]);
    }
}
