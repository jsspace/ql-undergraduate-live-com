<?php

namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Data;


class DataController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'cache' => [
                'class' => 'yii\filters\PageCache',
                'duration' => 60,
                'variations' => [
                    \Yii::$app->language,
                ],
            ],
        ];
    }
    
    
    public function actionList()
    {
        $dataList = Data::find()
        ->orderBy('ctime desc')
        ->all();
        return $this->render('list', ['dataList' => $dataList]);
    }

    public function actionDetail()
    {
        $dataid = Yii::$app->request->get('dataid');
        $dataDetail = Data::find()
        ->where(['id' => $dataid])
        ->one();
        return $this->render('detail', ['dataDetail' => $dataDetail]);
    }

}
