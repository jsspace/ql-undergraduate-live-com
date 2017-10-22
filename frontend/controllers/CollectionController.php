<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\Collection;
use backend\models\Course;

class CollectionController extends \yii\web\Controller
{   
    public function actionAdd()
    {
        if(Yii::$app->user->isGuest) {
            $data['status'] = '4';
            $data['message'] = '请先登录';
            return json_encode($data);
        }
        $data = Yii::$app->request->Post();
        $course_id = $data['course_id'];
        $is_exist = Collection::find()
        ->where(['courseid' => $course_id])
        ->andWhere(['userid' => Yii::$app->user->id])
        ->one();
        if (!empty($is_exist)) {
            $data['status'] = '2';
            $data['message'] = '已收藏';
        } else {
            $course = Course::find()
            ->where(['id' => $course_id])
            ->one();
            $course->collection = $course->collection+1;
            $course_result = $course->save();
            $collect = new Collection();
            $collect->userid = Yii::$app->user->id;
            $collect->courseid = $course_id;
            $result = $collect->save();
            if ($result&&$course_result) {
                $data['status'] = '1';
                $data['message'] = '收藏成功';
            } else {
                $data['status'] = '0';
                $data['message'] = '收藏失败';
            }
        }
        return json_encode($data);
    }
}
