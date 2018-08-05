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
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use backend\models\MemberGoods;
use backend\models\CoursePackage;
use backend\models\CourseCategory;
use backend\models\Cities;
use backend\models\Read;
use yii\helpers\Html;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */

    public $layout = 'user-main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'edit' => ['POST', 'GET'],
                ],
            ],
        ];
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

    public function actionAskTeacher()
    {
        return $this->render('ask-teacher');
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
                $model->picture = '/'.Yii::$app->params['upload_img_dir'] . 'head_img/' . $randName;
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
        ->select('course_ids, invalid_time')
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->asArray()
        ->all();
        $goodsids = '';
        $course_invalid_time = [];
        foreach ($orderids as $key => $orderid) {
            $goodsids.=$orderid['course_ids'].',';
            $courseid_arr = explode(',', $orderid['course_ids']);
            foreach ($courseid_arr as $key => $courseid) {
                $course_invalid_time[$courseid] = $orderid['invalid_time'];
            }
        }
        $goodsid_arr = explode(',', $goodsids);
        $clist = Course::find()
        ->with('courseSections')
        ->where(['in', 'id', $goodsid_arr])
        ->all();
        return $this->render('course', [
            'clist' => $clist,
            'course_invalid_time' => $course_invalid_time
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
    public function actionMember()
    {
        $member_models = MemberGoods::find()
        ->where(['user_id' => Yii::$app->user->id])
        ->andWhere(['pay_status' => 2])
        ->andWhere(['>', 'end_time', time()])
        ->all();
        return $this->render('member', [
            'member_models' => $member_models,
        ]);
    }
    
    public function actionClass()
    {
        $results = CoursePackage::getUserClass();
        $course_package_arr = $results['course_package_arr'];
        $package_invalid_time = $results['package_invalid_time'];
//         print_r($course_package_arr);die;
        return $this->render('class', [
            'course_package_arr' => $course_package_arr,
            'package_invalid_time' => $package_invalid_time
        ]);
    }
    public function actionCitys()
    {
        $get = Yii::$app->request->get();
        $provinceid = $get['provinceid'];
        $model = Cities::items($provinceid);
        foreach($model as $id => $name) {
            echo Html::tag('option', Html::encode($name), array('value' => $id));
        }
    }
    public function actionMessage()
    {
        $messages = Read::find()
        ->where(['userid' => Yii::$app->user->id])
        ->orderBy([
          'status' => SORT_ASC,
          'get_time'=>SORT_DESC
        ])->all();
        return $this->render('message', [
            'messages' => $messages
        ]);
    }
    public function actionMessageView()
    {
        $get = Yii::$app->request->get();
        $read_id = $get['id'];
        $readModel = Read::find()
        ->where(['id' => $read_id])
        ->one();
        $readModel->status = 1;
        $readModel->read_time = time();
        $readModel->save(false);
        return $this->render('message-view', [
            'read' => $readModel
        ]);
    }
    
    public function actionChangePassword()
    {
        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            
            if (!isset($data['old_password']) || !isset($data['new_password']) || !isset($data['renew_password'])) {
                $msg = [
                    'status' => 1,
                    'message' => '参数不全',
                ];
                return json_encode($msg);
            }
            
            $user = User::find()
            ->where(['id' => Yii::$app->user->id])
            ->one();
            
            if (Yii::$app->security->validatePassword($data['old_password'], $user->password_hash)) {
                if ($data['new_password'] == $data['renew_password']) {
                    $user->password_hash = Yii::$app->security->generatePasswordHash($data['new_password']);
                    $user->save();
                    $msg = [
                        'status' => 0,
                        'message' => '密码修改成功',
                    ];
                    return json_encode($msg);
                } else {
                    $msg = [
                        'status' => 2,
                        'message' => '新密码与重复新密码不相同，请重新输入',
                    ];
                    return json_encode($msg);
                }
            } else {
                $msg = [
                    'status' => 3,
                    'message' => '老密码输入错误，请重新输入',
                ];
                return json_encode($msg);
            }
        }
        return $this->render('change-password');
    }
}
