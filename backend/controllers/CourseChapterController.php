<?php

namespace backend\controllers;

use Yii;
use backend\models\Course;
use backend\models\CourseChapter;
use backend\models\CourseChapterSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
        ->with('courseSections')
        ->orderBy('position ASC')
        ->all();
        $course = Course::find()
        ->where(['id' => $course_id])
        ->one();
        $chapters_arr = array();
        $sections_arr = array();
        $chapters = array();
        foreach ($coursechapters as $key => $coursechapter) {
            $chapters_arr[$key]=array();
            $chapters_arr[$key]['chapter_id'] = $coursechapter->id;
            $chapters_arr[$key]['parent_id'] = '0';
            $chapters_arr[$key]['name'] = $coursechapter->name;
            $chapters_arr[$key]['chapter_type'] = 'folder';
            $chapters[] = json_encode($chapters_arr[$key]);
            $sections = $coursechapter->courseSections;
            foreach ($sections as $sectionkey => $section) {
                $sections_arr[$sectionkey]=array();
                $sections_arr[$sectionkey]['chapter_id'] = $section->id;
                $sections_arr[$sectionkey]['parent_id'] = $coursechapter->id;
                $sections_arr[$sectionkey]['name'] = $section->name;
                $sections_arr[$sectionkey]['chapter_type'] = 'file';
                $chapters[] = json_encode($sections_arr[$sectionkey]);
            }
        }
        return $this->render('index', [
            'chapters' => $chapters,
            'course' => $course,
        ]);
    }

    /**
     * Displays a single CourseChapter model.
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
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CourseChapter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing CourseChapter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
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
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
