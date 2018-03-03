<?php

namespace backend\controllers;

use Yii;
use backend\models\Message;
use backend\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use backend\models\OrderGoods;
use backend\models\Read;
use backend\models\OrderInfo;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
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
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionReview()
    {
        $id = Yii::$app->request->get('msg_id');
        $message = $this->findModel($id);
        /* 如果审核已通过，填充消息的发布时间并将消息保存到用户的系统消息表，初始状态为未读 */
        $userIdArr = array();
        //$classIdsArr = explode(',', $message->classids);
        $classIdsArr = array('alluser');
        if (in_array('alluser', $classIdsArr)) {
            /*$userNameIdArr1 = User::users('student');
            $userNameIdArr2 = User::users('school');
            $userNameIdArr = array_merge($userNameIdArr1, $userNameIdArr2);
            $userIdArr = array_keys($userNameIdArr);*/
            /*$orderGoods = OrderInfo::find()
            ->select('user_id')
            ->where(['pay_status' => 2])
            ->asArray()
            ->all();
            $userIdArr = array_column($orderGoods, 'user_id');*/
            $students = User::users('student');
            $schools = User::users('school');
            $studentsIdArr = array_keys($students);
            $schoolsIdArr = array_keys($schools);
            $userIdArr = array_merge($studentsIdArr, $schoolsIdArr);
        } else if(in_array('allclass', $classIdsArr)) {
            $orderGoods = OrderGoods::find()
            ->select('user_id')
            ->where(['type' => 'course_package'])
            ->andWhere(['pay_status' => 2])
            ->asArray()
            ->all();
            $userIdArr = array_column($orderGoods, 'user_id');
        } else {
            $orderGoods = OrderGoods::find()
            ->select('user_id')
            ->where(['type' => 'course_package'])
            ->andWhere(['pay_status' => 2])
            ->andWhere(['goods_id' => $classIdsArr])
            ->asArray()
            ->all();
            $userIdArr = array_column($orderGoods, 'user_id');
        }
        $userIdArr = array_unique($userIdArr);
        $isadmin = User::isAdmin($message->publisher);
        if(!$isadmin) {
        //市场专员身份发送信息
            foreach ($userIdArr as $key => $userId) {
                if (User::getUserModel($userId)->cityid != $message->cityid) {
                    unset($userIdArr[$key]);
                }
            }
        }
        /* 添加用户消息表 */
        foreach ($userIdArr as $key => $userId) {
            $readModel = new Read();
            $readModel->msg_id = $message->msg_id;
            $readModel->userid = $userId;
            $readModel->get_time = time();
            $readModel->save(false);
        }
        $message->publish_time = time();
        $message->status = 1;
        $message->save(false);
        return $this->redirect('index');
    }

    /**
     * Displays a single Message model.
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
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->msg_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            return $this->redirect(['view', 'id' => $model->msg_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Message model.
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
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
