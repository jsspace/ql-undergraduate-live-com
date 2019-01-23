<?php

namespace frontend\controllers;

use backend\models\Information;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;


class InformationController extends Controller {

    public function actionList() {
        $information = Information::find()
            ->orderBy('release_time desc');
        $pages = new Pagination(['totalCount' => $information->count(), 'pageSize' => '5']);
        $models = $information->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('list', ['informations' => $models, 'pages' => $pages]);
    }

    public function actionDetail($information_id) {
        $information = Information::find()->where(['id' => $information_id])->one();
        if (!empty($information)) {
            return $this->render('detail', ['information' => $information]);
        }
    }

}