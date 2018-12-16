<?php

namespace backend\controllers;

use Yii;
use backend\models\Course;
use backend\models\CourseChapter;
use backend\models\CourseChapterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CourseChapterController implements the CRUD actions for CourseChapter model.
 */
class CourseChapterController extends Controller
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
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all CourseChapter models.
     * @return mixed
     */

    public function actionIndex()
    {
        $request = Yii::$app->request->queryParams;
        $course_id = $request['course_id'];
        $coursechapters = CourseChapter::find()
        ->where(['course_id' => $course_id])
        ->with([
            'courseSections' => function($query) {
                $query->orderBy('position ASC')
                ->with(['courseSectionPoints' => function($query) {
                    $query->orderBy('position ASC');
                }]);
            }
        ])
        ->orderBy('position ASC')
        ->all();

        $course = Course::find()
        ->where(['id' => $course_id])
        ->one();

        $chapters = array();

        foreach ($coursechapters as $key => $coursechapter) {
            $chapters_arr=array();
            $chapters_arr['state']['cid'] = $coursechapter->id;
            $chapters_arr['state']['opened'] = true;
            $chapters_arr['text'] = $coursechapter->name;
            $chapters_arr['type'] = 'chapter';
            $chapters_arr['children'] = array();
            if (!empty($coursechapter->courseSections)) {
                $sections = $coursechapter->courseSections;
                foreach ($sections as $sectionkey => $section) {
                    $sections_arr = array();
                    $sections_arr['state']['cid'] = $section->id;
                    $sections_arr['state']['opened'] = true;
                    $sections_arr['text'] = $section->name;
                    $sections_arr['type'] = 'section';
                    $sections_arr['children'] = array();
                    if (!empty($section->courseSectionPoints)) {
                        $points = $section->courseSectionPoints;
                        foreach ($points as $pointkey => $point) {
                            $points_arr=array();
                            $points_arr['state']['cid'] = $point->id;
                            $points_arr['state']['opened'] = true;
                            $points_arr['text'] = $point->name;
                            $points_arr['type'] = 'point';
                            $sections_arr['children'][] = $points_arr;
                        }
                    }
                    $chapters_arr['children'][] = $sections_arr;
                }
            }
            $chapters[] = $chapters_arr;
        }
        return $this->render('index', [
            'chapters' => json_encode($chapters),
            'course' => $course,
        ]);
    }

    /**
     * Displays a single CourseChapter model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CourseChapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseChapter();

        $request = Yii::$app->request->queryParams;
        $course_id = $request['course_id'];
        $model->course_id = $course_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CourseChapter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CourseChapter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return 'success';
    }

    /**
     * Finds the CourseChapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CourseChapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseChapter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
