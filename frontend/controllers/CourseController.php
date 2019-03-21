<?php

namespace frontend\controllers;

use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\models\CourseCategory;
use backend\models\Course;
use backend\models\CourseChapter;
use backend\models\CourseSection;
use backend\models\CourseSectionPoints;
use backend\models\CourseComent;
use backend\models\CoursePackage;
use backend\models\Data;
use backend\models\Quas;
use backend\models\User;
use backend\models\UserStudyLog;
use backend\models\UserHomework;
use Qiniu\Auth;
use Yii;
use yii\data\Pagination;
use yii\web\UploadedFile;
use components\helpers\QiniuUpload;

class CourseController extends Controller
{
        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['qvaluate', 'ques'],
                'rules' => [
                    [
                        'actions' => ['qvaluate', 'ques'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'qvaluate' => ['post'],
                    'ques' => ['post'],
                ],
            ],
        ];
    }
    
    
    public function actionList()
    {
        $courses = Course::find()
        ->where(['onuse' => 1])
        ->andWhere(['type' => 1])
        ->with([
            'courseChapters' => function($query) {
                $query->with(['courseSections' => function($query) {
                    $query->with('courseSectionPoints');
                }]);
            }
        ])
        ->orderBy('create_time desc');
        $pages = new Pagination(['totalCount' => $courses->count(), 'pageSize' => '5']);
        $models = $courses->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('list', ['courses' => $models, 'pages' => $pages]);
    }

    public function actionOpen()
    {
        $courses = Course::find()
        ->where(['onuse' => 1])
        ->andWhere(['type' => 2])
        ->orderBy('create_time desc');
        $pages = new Pagination(['totalCount' => $courses->count(), 'pageSize' => '12']);
        $models = $courses->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
        return $this->render('open', ['courses' => $models, 'pages' => $pages]);
    }

    public function actionSearch()
    {
        $searchContent = Yii::$app->request->get('searchContent');
        $coursemodels = Course::find()
        ->where(['like', 'course_name', $searchContent])
        ->all();
        return $this->render('search', ['coursemodels' => $coursemodels]);
    }
    
    public function actionDetail($courseid, $invite=0)
    {
        //设置邀请人cookie
        $cookies = Yii::$app->response->cookies;
        if (!isset($cookies['invite']) && ($invite > 0)) {
            $cookies->add(new \yii\web\Cookie([
                'name' => 'invite',
                'value' => $invite,
                'expire'=>time()+3600*24*365
            ]));
        }
        $courseModel = Course::find()
        ->where(['id' => $courseid])
        ->with([
            'courseChapters' => function($query) {
                $query->with(['courseSections' => function($query) {
                    $query->with('courseSectionPoints');
                }]);
            }
        ])
        ->one();
        //浏览次数加1
        $courseModel->view = $courseModel->view+1;
        $courseModel->save();
        // 课程评价
        // $course_comments = CourseComent::find()
        // ->where(['course_id' => $courseid])
        // ->andWhere(['check' => 1])
        // ->orderBy('id desc')
        // ->all();
        //课程资料
        // $datas = Data::find()
        // ->where(['course_id' => $courseid])
        // ->orderBy('id desc')
        // ->all();
        /* 教师答疑 */
        // $quas = Quas::find()
        // ->where(['course_id' => $courseid])
        // ->orderBy('id desc')
        // ->andWhere(['check' => 1])
        // ->all();
        /* 获取所有学员 */
        // $studyids = UserStudyLog::find()
        // ->select('userid')
        // ->where(['courseid' => $courseid])
        // ->orderBy('start_time desc')
        // ->asArray()
        // ->all();
        // $studyids = array_column($studyids, 'userid');
        // $studyids = array_unique($studyids);
        return $this->render('detail', ['course' => $courseModel]);
    }

    public function actionTry()
    {
        if (Yii::$app->user->isGuest) {
            $result['status'] = 0;
            $result['message'] = '请先登陆再观看课程';
        } else {
            $data = Yii::$app->request->Post();
            $section_id = $data['section_id'];
            $section = CourseSection::find()
            ->where(['id' => $section_id])
            ->one();
            $result['status'] = 1;
            $result['video_url'] = $section->video_url;
        }
        return json_encode($result);
    }

    public function actionEvaluate()
    {
        $data = Yii::$app->request->Post();
        $courseid = $data['course_id'];
        $content = $data['content'];
        $course_comment = new CourseComent();
        $course_comment->course_id = $courseid;
        $course_comment->content = $content;
        $course_comment->user_id = Yii::$app->user->id;
        $result = $course_comment->save();
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = '提交成功,等待审核！';
        } else {
            $data['status'] = 'error';
            $data['message'] = '提交失败';
        }
        return json_encode($data);
    }

    public function actionQues()
    {
        $data = Yii::$app->request->Post();
        $courseid = $data['course_id'];
        $content = $data['content'];
        $course_quas = new Quas();
        $course_quas->course_id = $courseid;
        $course_quas->teacher_id = Course::teacher($courseid);
        $course_quas->question = $content;
        $course_quas->student_id = Yii::$app->user->id;
        $course_quas->question_time = time();
        $course_quas->check = 0;
        $result = $course_quas->save();
        if ($result) {
            $data['status'] = 'success';
            $data['message'] = '问题提交成功,等待审核！';
        } else {
            $data['status'] = 'error';
            $data['message'] = '提交失败';
        }
        return json_encode($data);
    }
    public function actionCheck()
    {
        if (Yii::$app->user->isGuest) {
            $data['status'] = 0;
            $data['message'] = '请先登陆再观看课程';
            return json_encode($data);
        }
        $data = Yii::$app->request->Post();
        $point_id = $data['point_id'];
        $course_id = $data['course_id'];
        $point = CourseSectionPoints::find()
        ->where(['id' => $point_id])
        ->one();
        $userid = Yii::$app->user->id;
        /* 获取学员观看日志 */
        $study_log = UserStudyLog::find()
        ->where(['userid' => $userid])
        ->andWhere(['courseid' => $course_id])
        ->andWhere(['pointid' => $point_id])
        ->orderBy('id desc')
        ->one();
        $current_time = 0;
        if ($study_log) {
            $current_time = $study_log->current_time;
        }
        if (!empty($point)) {
            if ($point->paid_free == 0) {
                $data['status'] = 1;
                $data['current_time'] = $current_time;
                $data['message'] = '正在请求观看免费课程';
                $data['url'] = $point->video_url;
                return json_encode($data);
            } else {
                //$is_member = Course::ismember($course_id, Yii::$app->user->id);
                /*判断是否是该分类下的会员*/
                /*if ($is_member == 1) {
                    $data['status'] = '4';
                    $data['message'] = '会员，允许观看';
                    $data['url'] = $video_url;
                    return json_encode($data);
                }*/
                $ispay = Course::ispay($course_id, $userid);
                /*判断是否已经购买*/
                /*$roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
                $isschool = 0;
                if (array_key_exists('school',$roles_array)) {
                    $isschool = 1;
                }*/
                if ($ispay == 1/* || $isschool == 1*/) {
                    $auth = new Auth(Yii::$app->params['access_key'], Yii::$app->params['secret_key']);
                    $video_url = $auth->privateDownloadUrl($point->video_url, $expires = 3600);
                    $data['status'] = '2';
                    $data['current_time'] = $current_time;
                    $data['message'] = '用户已经购买了该课程，允许观看';
                    $data['url'] = $video_url;
                } else {
                    $data['status'] = '3';
                    $data['message'] = '您尚未购买该课程，请先购买后再观看';
                    $data['url'] = '';
                }
                return json_encode($data);
            }
        }
    }
    public function actionGetOpenUrl()
    {
        if (Yii::$app->user->isGuest) {
            $data['status'] = 0;
            $data['message'] = '请先登陆再观看课程';
            return json_encode($data);
        }
        $data = Yii::$app->request->Post();
        $course_id = $data['course_id'];
        
        $course = Course::find()
        ->where(['id' => $course_id])
        ->select('open_course_url')
        ->one();
        $open_url = $course->open_course_url;
        $data['status'] = 1;
        $data['url'] = $open_url;
        /* 获取学员观看日志 */
        $userid = Yii::$app->user->id;
        $study_log = UserStudyLog::find()
        ->where(['userid' => $userid])
        ->andWhere(['courseid' => $course_id])
        ->orderBy('id desc')
        ->one();
        $current_time = 0;
        if ($study_log) {
            $current_time = $study_log->current_time;
        }
        $data['current_time'] = $current_time;
        return json_encode($data);
    }
    public function actionOpenCheck()
    {
        if (Yii::$app->user->isGuest) {
            $data['status'] = 0;
            $data['message'] = '请先登陆再观看课程';
            return json_encode($data);
        }
        $data = Yii::$app->request->Post();
        $section_id = $data['section_id'];
        $course_id = $data['course_id'];
        $section = CourseSection::find()
        ->where(['id' => $section_id])
        ->one();
        $userid = Yii::$app->user->id;
        /* 获取学员观看日志 */
        $study_log = UserStudyLog::find()
        ->where(['userid' => $userid])
        ->andWhere(['courseid' => $course_id])
        ->andWhere(['sectionid' => $section_id])
        ->orderBy('id desc')
        ->one();
        $current_time = 0;
        if ($study_log) {
            $current_time = $study_log->current_time;
        }
        if (!empty($section)) {
            if ($section->paid_free == 0) {
                $data['status'] = 1;
                $data['current_time'] = $current_time;
                $data['message'] = '正在请求观看免费课程';
                $data['url'] = $section->video_url;
                return json_encode($data);
            } else {
                $auth = new Auth(Yii::$app->params['access_key'], Yii::$app->params['secret_key']);
                $video_url = $auth->privateDownloadUrl($section->video_url, $expires = 3600);
                //$is_member = Course::ismember($course_id, Yii::$app->user->id);
                /*判断是否是该分类下的会员*/
                /*if ($is_member == 1) {
                    $data['status'] = '4';
                    $data['message'] = '会员，允许观看';
                    $data['url'] = $video_url;
                    return json_encode($data);
                }*/
                $ispay = Course::ispay($course_id, $userid);
                /*判断是否已经购买*/
                /*$roles_array = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
                $isschool = 0;
                if (array_key_exists('school',$roles_array)) {
                    $isschool = 1;
                }*/
                if ($ispay == 1/* || $isschool == 1*/) {
                    $data['status'] = '2';
                    $data['current_time'] = $current_time;
                    $data['message'] = '用户已经购买了该课程，允许观看';
                    $data['url'] = $video_url;
                } else {
                    $data['status'] = '3';
                    $data['message'] = '您尚未购买该课程，请先购买后再观看';
                    $data['url'] = '';
                }
                return json_encode($data);
            }
        }
    }
    public function actionAddnetlog() {
        $result = array();
        if (!Yii::$app->user->isGuest) {
            $data = Yii::$app->request->Post();
            //$userlogs = $data['userlog'];
            /*if (empty($userlogs)) {
                return $result['status'] = 1;//'未观看任何视频'
                $result['msg'] = '未观看任何视频';
            } else {*/
                //foreach ($userlogs as $key => $userlog) {
                    $userid = Yii::$app->user->id;
                    //$course_id = $userlog['courseId'];
                    //$section_id = $userlog['sectionId'];
                    $course_id = $data['courseId'];
                    $point_id = $data['pointId'];
                    $current_time = $data['current_time'];
                    $point = CourseSectionPoints::find()
                    ->where(['id' => $point_id])
                    ->one();
                    $points_arr = explode(':', $point->duration);
                    $seconds = $points_arr[0]*60 + $points_arr[1];
                    //$type = 1;
                    $start = strtotime(date('Y-m-d 00:00:00'));
                    $end = strtotime(date('Y-m-d H:i:s'));
                    $model = UserStudyLog::find()
                    ->where(['userid' => $userid])
                    ->andWhere(['courseid' => $course_id])
                    ->andWhere(['pointid' => $point_id])
                    ->andWhere(['between', 'start_time', $start, $end])
                    ->one();
                    if (empty($model)) {
                        $model = new UserStudyLog();
                        $model->userid = $userid;
                        $model->start_time = time();
                        $model->duration = 1;
                        $model->courseid = $course_id;
                        $model->pointid = $point_id;
                        //$model->type = $type;
                    } else {
                        $model->duration = intval($model->duration)+1;
                    }
                    if ($current_time>=$seconds) {
                        $model->iscomplete = 1;
                    }
                    $model->current_time = $current_time;
                    $model->save(false);
                //}
                $result['status'] = 2;
                $result['msg'] = '保存成功';
            //}
        } else {
            $result['status'] = 0;//'游客
            $result['msg'] = '游客';
        }
        return json_encode($result);
    }
    public function actionAddopenlog() {
        $result = array();
        if (!Yii::$app->user->isGuest) {
            $data = Yii::$app->request->Post();
            $userid = Yii::$app->user->id;
            $net_type = $data['type'];
            $course_id = $data['courseId'];
            $current_time = $data['current_time'];
            //$type = 1;
            $start = strtotime(date('Y-m-d 00:00:00'));
            $end = strtotime(date('Y-m-d H:i:s'));
            $model = UserStudyLog::find()
            ->where(['userid' => $userid])
            ->andWhere(['courseid' => $course_id])
            ->andWhere(['between', 'start_time', $start, $end])
            ->one();
            if (empty($model)) {
                $model = new UserStudyLog();
                $model->userid = $userid;
                $model->start_time = time();
                $model->duration = 1;
                $model->courseid = $course_id;
                $model->sectionid = 0;
                $model->type = 'open';
            } else {
                $model->duration = intval($model->duration)+1;
            }
            $model->current_time = $current_time;
            $model->save(false);
            $result['status'] = 2;
            $result['msg'] = '保存成功';
        } else {
            $result['status'] = 0;//'游客
            $result['msg'] = '游客';
        }
        return json_encode($result);
    }

    public function actionHomework() {
        $userid = Yii::$app->user->id;
        $data = Yii::$app->request->post();
        $count = $data['count'];
        $section_id = $data['section_id'];
        $course_id = $data['course_id'];

        // 假设提交的作业未审核通过，则先删除原先提交的作业


        $img_rootPath = Yii::getAlias("@frontend")."/web/" . Yii::$app->params['upload_img_dir'];
        $model = new UserHomework();
        $model->user_id = $userid;
        $model->course_id = $course_id;
        $model->section_id = $section_id;

        $img_rootPath .= 'user_homework/';
        if (!file_exists($img_rootPath)) {
            mkdir($img_rootPath, 0777, true);
        }
        for ($i = 0; $i < $count; $i++){
            $file = $_FILES['file' . $i];
            if ($file['error'] != 1) {
                $ext = array_pop(explode('.', $file['name']));
                $randName = time() . rand(1000, 9999) . '.' . $ext;

                move_uploaded_file($file['tmp_name'], $img_rootPath . $randName);
                $folder = 'user_homework';
                $result = QiniuUpload::uploadToQiniu($file, $img_rootPath . $randName, $folder, $ext);
                if (!empty($result)) {
                    print_r(Yii::$app->params['get_source_host'].'/'.$result[0]['key']);
                    $model->pic_url = $model->pic_url .Yii::$app->params['get_source_host'].'/'.$result[0]['key'] . ';';
                    @unlink($img_rootPath . $randName);
                }else {
                    return json_encode([
                        'status' => 'failed',
                        'reason' => 'uploadfailed'
                    ]);
                }
            }
        }
        $model->status = 1;
        $model->submit_time =  date('Y-m-d H:i:s',time());
        if ($model->save()) {
            return json_encode([
                'status' => 'success',
                'reason' => '上传成功！'
            ]);
        }else {
            return json_encode([
                'status' => 'failed',
                'reason' => 'save failed！'
            ]);
        }

    }
}
