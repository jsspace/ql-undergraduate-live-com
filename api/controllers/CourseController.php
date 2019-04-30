<?php

namespace api\controllers;

use backend\models\Book;
use backend\models\Collection;
use backend\models\CoursePackage;
use backend\models\CourseSectionPoints;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use backend\models\Course;
use backend\models\CourseCategory;
use backend\models\User;
use backend\models\CourseChapter;
use backend\models\CourseSection;
use backend\models\CourseComent;
use backend\models\Data;
use backend\models\Quas;
use backend\models\UserStudyLog;
use Qiniu\Auth;
use yii\data\Pagination;

/**
 * AudioController implements the CRUD actions for Audio model.
 */
class CourseController extends Controller
{
    public function actionList()
    {
        $courses = Course::find()
        ->where(['type' => 1])
        ->with([
            'courseChapters' => function($query) {
                $query->with(['courseSections' => function($query) {
                    $query->with('courseSectionPoints');
                }]);
            }
        ])
        ->orderBy('create_time desc')
        ->all();
        $result = array();
        foreach ($courses as $key => $course) {
            $id_arr = explode(',', $course->teacher_id);
            $teacher_name = '';
            foreach ($id_arr as $key => $id) {
                $teacher = User::getUserModel($id);
                if ($teacher) {
                    $teacher_name = $teacher->username.','.$teacher_name;
                }
            }
            if ($teacher_name) {
                // 去除最后一个逗号
                $teacher_name = substr($teacher_name, 0, strlen($teacher_name)-1);
            }
            $classrooms = 0;
            $chapters = $course->courseChapters;
            foreach ($chapters as $key => $chapter) {
                $sections = $chapter->courseSections;
                foreach ($sections as $key => $section) {
                    $points = $section->courseSectionPoints;
                    $classrooms += count($points);
                }
            }
            $content = array(
                'id' => $course->id,
                'course_name' => $course->course_name,
                'list_pic' => $course->list_pic,
                'discount' => $course->discount,
                'online' => $course->online,
                'teacher' => $teacher_name,
                'classrooms' => $classrooms
            );
            $result[] = $content;
        }
        return json_encode($result);
    }
    public function actionDetail()
    {
        $data = Yii::$app->request->get();
        $access_token = '';
        if (!empty($data['access-token'])) {
            $access_token = $data['access-token'];
        }
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        $courseid = $data['courseid'];
        $invite = 0;
        if (isset($data['invite'])) {
            $invite = $data['invite'];
        }
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
        $courseDetail = array();
        /* 课程详情 */
        $ismember = 0;
        $ispay = 0;
        $isschool = 0;
        $iscollect = false;
        if (!empty($user)) {
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
            if (array_key_exists('school',$roles_array)) {
                $isschool = 1;
            }
            $ismember = Course::ismember($courseModel->id, $user->id);
            $ispay = Course::ispay($courseModel->id, $user->id);
            $collection = Collection::find()->where(['userid' => $user->id, 'courseid' => $courseid])->one();
            if (!empty($collection)) {
                $iscollect = true;
            }
        }
        if ($courseModel->discount == 0) {
            $tag = 1; //公开课程
        } else if ($ismember == 1) {
            $tag = 2; //会员课程
        } else if ($ispay == 1) {
            $tag = 3; //已购买课程
        } else {
            $tag = 0; //尚未购买
        }
        $course = array(
            'id' => $courseModel->id,
            'course_name' => $courseModel->course_name,
            'discount' => $courseModel->discount,
            'price' => $courseModel->price,
            'home_pic' => $courseModel->home_pic,
            'view' => $courseModel->view,
            'collection' => $courseModel->collection,
            'online' => $courseModel->online,
            'intro' => $courseModel->des,
            'ispay' => $tag,
            'iscollect' => $iscollect,
            'course_type' => $courseModel->type
        );
        $courseDetail['course'] = $course;
        //课程教师
        $id_arr = explode(',', $courseModel->teacher_id);
        $teacher = array();
        if (count($id_arr) > 0) {
            foreach ($id_arr as $key => $id) {
                $teacher_model = User::getUserModel($id);
                if ($teacher_model) {
                    $teacher[] = array (
                        'teacher_img' => $teacher_model->picture,
                        'teacher_name' => $teacher_model->username,
                        'teacher_tag' => $teacher_model->description,
                        'office' => $teacher_model->office,
                        'unit' => $teacher_model->unit,
                        'goodat' => $teacher_model->goodat
                    );
                }
            }
        }
        $courseDetail['teacher'] = $teacher;
        return  json_encode($courseDetail);
    }
    public static function getVideoType($section)
    {
        $text = '';
        $current_time = date('Y-m-d H:i:s');
        $end_time = date('Y-m-d H:i:s',strtotime($section->start_time."+".$section->duration." minute"));
        //0 直播 2 直播答疑
        $video_url = $section->video_url;
        if ($section->type == 0 || $section->type == 2) {
            if ($current_time < $section->start_time) {
                $text = '最近直播：'.$section->start_time;
            } else if ($current_time >= $section->start_time && $current_time < $end_time) {
                 $text = '直播中';
            } else if ($current_time > $end_time) {
                $text = '直播回放';
            }
        } else if ($section->type == 1) {
            $text = '点播课程';
        }
        $url = '';
        if ($section->type == 0 || $section->type == 2) {
            $url = $section->video_url;
        }
        $result = array(
            'text' => $text,
            'url' => $url
        );
        return $result;
    }
    public function actionCheck()
    {
        $get = Yii::$app->request->get();
        $access_token = $get['access-token'];
        $user = \common\models\User::findIdentityByAccessToken($access_token);
        if (empty($user)) {
            $result = array(
                'status' => 0,
                'message' => '请先登陆再观看课程'
            );
            return json_encode($result);
        }

        $data = Yii::$app->request->get();
        $section_id = $data['section_id'];
        $course_id = $data['course_id'];
        $point_id = $data['point_id'];
        $section = CourseSection::find()
        ->where(['id' => $section_id])
        ->one();
        $course_info = Course::find()->select(['home_pic', 'teacher_id'])->where(['id' => $course_id])->one();

        $point = CourseSectionPoints::find()
            ->where(['id' => $point_id])
            ->one();
        // 如果是教师则直接可以看自己的课
        if ($user->getId() == $course_info->teacher_id) {
            $result = array(
                'status' => 6,
                'message' => '正在请求观看自己的课程',
                'url' => $point->video_url,
                'pic' => $course_info->home_pic
            );
            return json_encode($result);
        }
        if (!empty($point)) {
            if ($point->paid_free == 0) {
                $result = array(
                    'status' => 1,
                    'message' => '正在请求观看免费课程',
                    'url' => $point->video_url,
                    'pic' => $course_info->home_pic
                );
                return json_encode($result);
            } else {
                $auth = new Auth(Yii::$app->params['access_key'], Yii::$app->params['secret_key']);
                $video_url = $auth->privateDownloadUrl($point->video_url, $expires = 3600);
                $is_member = Course::ismember($course_id, $user->id);/*判断是否是该分类下的会员*/
                if ($is_member == 1) {
                    $result = array(
                        'status' => 4,
                        'message' => '会员，允许观看',
                        'url' => $video_url,
                        'pic' => $course_info->home_pic
                    );
                    return json_encode($result);
                }
                $ispay = Course::ispay($course_id, $user->id);/*判断是否已经购买*/
                $roles_array = Yii::$app->authManager->getRolesByUser($user->id);
                $isschool = 0;
                if (array_key_exists('school',$roles_array)) {
                    $isschool = 1;
                }
                if ($ispay == 1 || $isschool == 1) {
                    $result = array(
                        'status' => 2,
                        'message' => '用户已经购买了该课程，允许观看',
                        'url' => $video_url,
                        'pic' => $course_info->home_pic
                    );
                } else {
                    $result = array(
                        'status' => 3,
                        'message' => '您尚未购买该课程，请先购买后再观看',
                        'url' => ''
                    );
                }
                return json_encode($result);
            }
        }
    }
    public function actionNodes() {
        $get = Yii::$app->request->get();
        $pageSize = $get['pernumber'];
        $page = $get['page'];
        $courseChapter = CourseChapter::find()
        ->all();
        $course_nodes = CourseCategory::find()
        ->select('id, name')
        ->where(['not like', 'name', '公开课'])
        ->with([
            'courses' => function ($query){
                $query->select('id, course_name, category_name')
                ->where(['type' => 1])
                ->with(['courseChapters' => function ($query) {
                    $query->select('id, name, course_id');
                }]);
            }
        ]);
        //实例化分页类,带上参数(总条数,每页显示条数)
        $pages = new Pagination(['totalCount' =>$course_nodes->count(), 'pageSize' => $pageSize]);
        $models = $course_nodes->offset($pages->offset)->limit($pages->limit)
        ->all();
        $datas = array();
        foreach ($models as $key => $model) {
            foreach ($model->courses as $key => $course) {
                foreach ($course->courseChapters as $key => $chapter) {
                    $data = array();
                    $data['subid'] = $model->id;
                    $data['subname'] = $model->name;
                    $data['courseid'] = $course->id;
                    $data['coursename'] = $course->course_name;
                    $data['sectionid'] = $chapter->id;
                    $data['name'] = $chapter->name;
                    $datas[] = $data;
                }
            }
        }
        $result = array(
            'data' => $datas,
            'sectionsCount' => count($courseChapter)
        );
        return json_encode($result);
    }
    public function actionAllNodes() {
        $course_nodes = CourseCategory::find()
        ->select('id, name')
        ->where(['not like', 'name', '公开课'])
        ->with([
            'courses' => function ($query){
                $query->select('id, course_name, category_name')
                ->where(['type' => 1])
                ->with(['courseChapters' => function ($query) {
                    $query->select('id, name, course_id');
                }]);
            }
        ])
        ->asArray()
        ->all();
        return json_encode($course_nodes);
    }

    public function actionOpenDetail() {
        $get = Yii::$app->request->get();
        $course_id = $get['course_id'];
        $course = Course::find()
        ->where(['id' => $course_id])
        ->one();
        $result = array(
            'pic' => $course->list_pic,
            'course_name' => $course->course_name,
            'course_price' => $course->price,
        );
        return json_encode($result);
        
    }
 
    public function actionOpen() {
        $courses = Course::find()
        ->where(['onuse' => 1])
        ->andWhere(['type' => 2])
        ->orderBy('create_time desc')
        ->all();
        $result = array();
        foreach ($courses as $key => $course) {
            $content = array(
                'id' => $course->id,
                'course_name' => $course->course_name,
                'list_pic' => $course->list_pic,
                'intro' => $course->intro,
                'duration' => $course->duration
            );
            $result[] = $content;
        }
        return json_encode($result);
    }

    public function actionOpenCheck() {
        try {
            $post = Yii::$app->request->post();
            $access_token = $post['access-token'];
            $user = \common\models\User::findIdentityByAccessToken($access_token);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        } finally {
            if (empty($user)) {
                $result = array(
                    'status' => 0,
                    'message' => '请先登陆再观看课程',
                );
                return json_encode($result);
            }
            $course_id = $post['course_id'];
            $course = Course::find()
            ->where(['id' => $course_id])
            ->one();
            if($course->price == 0) {
                $result = array(
                    'status' => 4,
                    'message' => '该课程免费，可以直接观看',
                    'url' => $course->open_course_url
                );
                return json_encode($result);
            }
            $ispay = Course::ispay($course_id, $user->id);/*判断是否已经购买,84应该为$user->id*/
            $roles_array = Yii::$app->authManager->getRolesByUser($user->id);//84应该为$user->id
            $isschool = 0;
            if (array_key_exists('school',$roles_array)) {
                $isschool = 1;
            }
            if ($ispay == 1 || $isschool == 1) {
                $result = array(
                    'status' => 2,
                    'message' => '用户已经购买了该课程，允许观看',
                    'url' => $course->open_course_url
                );
            } else {
                $result = array(
                    'status' => 3,
                    'message' => '您尚未购买该课程，请先购买后再观看',
                    'url' => '',
                    'courseid' => $course->price
                );
            }
            return json_encode($result);
        }
    }

    /* 个人中心-我的课程$精品课-视频页接口 */
    public function actionCourseVideo()
    {
        $data = Yii::$app->request->get();
        $access_token = '';
        $course_id = $data['course_id'];
        $isPay = 0;
        if (!empty($data['access-token'])) {
            $access_token = $data['access-token'];
            $user = \common\models\User::findIdentityByAccessToken($access_token);
            // 判断用户是否购买该课程
            $isPay = Course::ispay($course_id, $user->id);
            if ($isPay != 0) {
                $course = Course::find()
                    ->where(['id' => $course_id])
                    ->with([
                        'courseChapters' => function($query) use($user) {
                            $query->with(['courseSections' => function($query) use($user){
                                $query->with(['courseSectionPoints' => function($query) use($user) {
                                    $query->with(['studyLog' => function($query) use($user) {
                                        $query->where(['userid' => $user->id])->orderBy('id desc')->one();
                                    }]);
                                }] );
                            }]);
                        },
                        'teacher'
                    ])->asArray()
                    ->one();
            } else {
                $course = Course::find()
                    ->where(['id' => $course_id])
                    ->with([
                        'courseChapters' => function($query) {
                            $query->with(['courseSections' => function($query) {
                                $query->with('courseSectionPoints');
                            }]);
                        },
                        'teacher'
                    ])->asArray()
                    ->one();
            }
        } else {
            $course = Course::find()
                ->where(['id' => $course_id])
                ->with([
                    'courseChapters' => function($query) {
                        $query->with(['courseSections' => function($query) {
                            $query->with('courseSectionPoints');
                        }]);
                    },
                    'teacher'
                ])->asArray()
                ->one();
        }
        $result = array();
        $result['status'] = 0;
        $result['course'] = $course;
        $result['ispay'] = $isPay;
        return json_encode($result);
    }

    public function actionCourseOrder()
    {
        $data = Yii::$app->request->get();
        $access_token = '';
        $result = array();
        $status = 0;
        $course_count = 1;
        $user_info = '';
        if (empty($data['access-token'])) {
            $status = -1;
            $message = 'please login first!';
            $result['status'] = $status;
            $result['message'] = $message;
            return json_encode($result);
        } else {
            $access_token = $data['access-token'];
            $user = \common\models\User::findIdentityByAccessToken($access_token);
            if (!empty($user)) {
                $user_info = User::find()->select(['username', 'phone', 'address'])->where(['id' => $user->id])
                    ->asArray()->one();
            }
            $courseid = $data['course_id'];
            $course_info = Course::find()->select(['course_name', 'list_pic', 'price', 'discount', 'category_name'])
                ->where(['id' => $courseid])->asArray()->one();
            $books = Book::find()
                ->where(['category' => $course_info['category_name']])
                ->andWhere(['like', 'name', '一本通'])
                ->asArray()->all();
            $tmp_arr = array();
            foreach($books as $k => $v)
            {
                if(in_array($v['id'], $tmp_arr))   //搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                {
                    unset($books[$k]); //销毁一个变量  如果$tmp_arr中已存在相同的值就删除该值
                }
                else {
                    $tmp_arr[$k] = $v['id'];  //将不同的值放在该数组中保存
                }
            }

            $result['status'] = $status;
            $result['user_info'] = $user_info;
            $result['course_info'] = $course_info;
            $result['books'] = $books;
            $result['course_count'] = $course_count;
            return json_encode($result);
        }
    }

    public function actionPackageOrder()
    {
        $data = Yii::$app->request->get();
        $access_token = $data['access-token'];

        $result = array();
        $status = 0;
        $course_count = 1;
        $user_info = '';

        if (empty($access_token)) {
            $status = -1;
            $message = 'please login first!';
            $result['status'] = $status;
            $result['message'] = $message;
            return json_encode($result);
        } else {
            $user = \common\models\User::findIdentityByAccessToken($access_token);
            if (!empty($user)) {
                $user_info = User::find()->select(['username', 'phone', 'address'])->where(['id' => $user->id])
                    ->asArray()->one();
            }
            $pid = $data['pid'];
            $course_info = CoursePackage::find()->select(['name', 'course','list_pic', 'price', 'discount'])
                ->where(['id' => $pid])->asArray()->one();
            $course_ids = $course_info['course'];
            $ids_arr = explode(',', $course_ids);
            $course_count = count($ids_arr);
            $books = array();
            foreach ($ids_arr as $id) {
                $course = Course::find()->select(['course_name', 'list_pic', 'price', 'discount', 'category_name'])
                    ->where(['id' => $id])->asArray()->one();
                $book = Book::find()
                    ->where(['category' => $course['category_name']])
                    ->andWhere(['like', 'name', '一本通'])
                    ->asArray()->all();
                $books[] = $book[0];
            }
            $tmp_arr = array();
            foreach($books as $k => $v)
            {
                if(in_array($v['id'], $tmp_arr))   //搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                {
                    unset($books[$k]); //销毁一个变量  如果$tmp_arr中已存在相同的值就删除该值
                }
                else {
                    $tmp_arr[$k] = $v['id'];  //将不同的值放在该数组中保存
                }
            }

            $result['status'] = $status;
            $result['course_info'] = $course_info;
            $result['user_info'] = $user_info;
            $result['books'] = $books;
            $result['course_count'] = $course_count;
            return json_encode($result);
        }
    }

}
