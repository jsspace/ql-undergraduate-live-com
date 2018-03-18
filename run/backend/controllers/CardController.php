<?php

namespace backend\controllers;

use Yii;
use backend\models\Card;
use backend\models\CardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
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
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
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
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Card();
        $data = Yii::$app->request->post();
        $card_num = $data['card_num'];
        $card_money = $data['card_money'];
        $success_num = 0;
        for ($i=0; $i < $card_num; $i++) {
            $model->isNewRecord=true;
            $card_id = self::create_code(16);
            $card_pass = self::create_code(8);
            $model->card_id = $card_id;
            $model->card_pass = $card_pass;
            $model->money = $card_money;
            if ($model->save()) {
                $success_num++;
            }
        }
        $result = array();
        $result['status'] = 'success';
        $result['num'] = $success_num;
        return json_encode($result);
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->card_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Card model.
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
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public static function create_code($length = 8) {
        // 密码字符集，可任意添加你需要的字符
        $chars = '0123456789';
        $card_id = '';
        for ( $i = 0; $i < $length; $i++ ) 
        {
          // 这里提供两种字符获取方式
          // 第一种是使用 substr 截取$chars中的任意一位字符；
          // 第二种是取字符数组 $chars 的任意元素
          // $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            $card_id .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $card_id;
    }
}
