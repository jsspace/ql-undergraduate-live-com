<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;
use backend\models\Provinces;
use backend\models\Cities;
use backend\models\User;
use backend\models\UserStudyLog;

$this->title = '我的课程';
AppAsset::addCss($this,'@web/css/list.css');

?>
<div class="htcontent">
    <h2 class="htwx cc"><a href="/">首页</a>&gt;<a href="#">我的课程</a></h2>
    <div class="htbox2">
        <div class="httxt1 cc">
            <h3 class="ht_tt1">我的班级</h3>
            <dl class="cc">
                <dd class="htqhnow">正在学</dd>
                <dd class="htqh2">已结课</dd>
            </dl>
            <ul>
            <?php foreach ($clist as $key => $course) {
                    if ($course_invalid_time[$course->id] > time() && $course->type == 1) {
                        $chapters = $course->courseChapters;
                        $classrooms = 0; //课堂学
                        $homeworks = 0; //随堂练（作业）
                        $unit_test = count($chapters); //单元测验
                        foreach ($chapters as $key => $chapter) {
                            $sections = $chapter->courseSections;
                            $homeworks += count($sections);
                            foreach ($sections as $key => $section) {
                                $points = $section->courseSectionPoints;
                                $classrooms += count($points);
                            }
                        }
                        
                        $studyids = UserStudyLog::find()
                        ->select('userid')
                        ->where(['courseid' => $course->id])
                        ->orderBy('start_time desc')
                        ->asArray()
                        ->all();
                        $studyids = array_column($studyids, 'userid');
                        $studyids = array_unique($studyids);
                        $classmates = count($studyids);
                    ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" target='_blank'>
                            <img src="/images/htpic2.jpg" width="298" height="108" />
                            <h4><?= $course->course_name ?></h4>
                            <h5>
                                <a href="<?= Url::to(['teacher/detail', 'userid' => $course->head_teacher]) ?>" target='_blank'>
                                    <img src="/images/htpic3.jpg" width="70" height="70" /><p>班主任</p>
                                </a>
                            </h5>
                            <div class="tyny">
                                <p><img src="/images/nyicon1.png" />课堂学（<?= $classrooms ?>）</p>
                                <p><img src="/images/nyicon1a.png" />随堂练（<?= $classrooms ?>）</p>
                                <p><img src="/images/nyicon1b.png" />单元测验（<?= $unit_test ?>）</p>
                                <!-- <p><img src="/images/nyicon1.png" />模拟考（<?= $course->examination_time; ?>）</p> -->
                                <p class="httx"><img src="/images/hticon10.png" />同学<?= $classmates ?></p>
                            </div>
                        </a>
                    </li>
                <?php } } ?>
            </ul>
            <ul style="display:none">
                <?php foreach ($clist as $key => $course) {
                    if ($course_invalid_time[$course->id] < time() && $course->type == 1) {
                        $chapters = $course->courseChapters;
                        $classrooms = 0; //课堂学
                        $homeworks = 0; //随堂练（作业）
                        $unit_test = count($chapters); //单元测验
                        foreach ($chapters as $key => $chapter) {
                            $sections = $chapter->courseSections;
                            $homeworks += count($sections);
                            foreach ($sections as $key => $section) {
                                $points = $section->courseSectionPoints;
                                $classrooms += count($points);
                            }
                        }
                        
                        $studyids = UserStudyLog::find()
                        ->select('userid')
                        ->where(['courseid' => $course->id])
                        ->orderBy('start_time desc')
                        ->asArray()
                        ->all();
                        $studyids = array_column($studyids, 'userid');
                        $studyids = array_unique($studyids);
                        $classmates = count($studyids);
                    ?>
                    <li>
                        <a href="<?= Url::to(['course/detail', 'courseid' => $course->id]) ?>" target='_blank'>
                            <img src="/images/htpic2.jpg" width="298" height="108" />
                            <h4><?= $course->course_name ?></h4>
                            <h5>
                                <a href="<?= Url::to(['teacher/detail', 'userid' => $course->head_teacher]) ?>" target='_blank'>
                                    <img src="/images/htpic3.jpg" width="70" height="70" /><p>班主任</p>
                                </a>
                            </h5>
                            <div class="tyny">
                                <p><img src="/images/nyicon1.png" />课堂学（<?= $classrooms ?>）</p>
                                <p><img src="/images/nyicon1a.png" />随堂练（<?= $classrooms ?>）</p>
                                <p><img src="/images/nyicon1b.png" />单元测验（<?= $unit_test ?>）</p>
                                <p><img src="/images/nyicon1.png" />模拟考（<?= $course->examination_time; ?>）</p>
                                <p class="httx"><img src="/images/hticon10.png" />同学<?= $classmates ?></p>
                            </div>
                        </a>
                    </li>
                <?php } } ?>
            </ul>
        </div>
        <div class="httxt1 cc course-content">
            <h3 class="ht_tt1">我的公开课</h3>
            <ul class="open-course-list list">
                <?php foreach ($clist as $key => $course) {
                    if ($course->type == 2) {
                ?>
                    <li>
                        <a href="javascript: void(0)">
                            <div class="course-img">
                                <div class="bg"></div>
                                <span class="video-play-btn" data-value="<?= $course->id ?>"></span>
                                <img class="course-pic" src="<?= $course->list_pic; ?>"/>
                            </div>
                            <span class="content-title"><?= $course->course_name; ?></span>
                            <span class="course-time"><?= date('Y-m-d H:i', $course->create_time); ?></span>
                        </a>
                        <div class="teacher-section">
                            <span class="teacher-name">主讲人：<?= User::item($course->teacher_id); ?></span>
                            <span class="course-price">价格：<?= $course->discount; ?>元</span>
                        </div>
                    </li>
                <?php } } ?>
            </ul>
        </div>
    </div>
</div>
<div class="video-layout _video-layout">
    <div class="video-box _video-box">
        <div class="_close-video-btn close-video-btn">
            <img src="//static-cdn.ticwear.com/cmww/statics/img/product/mini/mini-confirm-close-btn.png">
        </div>
        <!-- <iframe width="100%" height="100%" src="" frameborder="0" allowfullscreen=""></iframe> -->
        <video id="course-video" width="100%" height="100%" controls="controls"></video>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        function qiehuan(qhan,qhshow,qhon){
            $(qhan).click(function(){
                $(qhan).removeClass(qhon);
                $(this).addClass(qhon);
                var i = $(this).index(qhan);
                $(qhshow).eq(i).show().siblings(qhshow).hide();
            });
        }
        qiehuan(".httxt1 dd",".httxt1 ul","htqhnow");

        $(".httxt2_show dl dt").click(function(){
            $(".httxt2_show dl").removeClass("ktshow");
            $(this).parent().addClass("ktshow");
        })
    });
</script>
<script src="<?= Url::to('@web/skin/layer.js');?>"></script>
<script type="text/javascript" src="/js/course.js"></script>