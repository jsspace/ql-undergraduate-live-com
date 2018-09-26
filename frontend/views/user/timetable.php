<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::addCss($this,'@web/css/timetable.css');
$this->title = '备考计划';

?>

<div class="htcontent">
        <h2 class="htwx cc"><a href="#">首页</a>&gt;<a href="#">备考计划</a></h2>
        <div class="htbox2">
            <div class="about-content">
                <h1>山东专升本考生备考时间规划</h1>
                <p class="sub-title">专升本考前复习是一项系统的工程，正规复习应涵盖三个阶段</p>
                <h3>第一阶段：基础学习阶段（6个月，9月份以前）</h3>
                <ul>
                    <li>首先启动英语学习，记忆单词是前期主要工作，坚持每天记100个单词，反复循环记忆；单词掌握到一定量后开始进入英语阅读阶段，
                        建议从近10年真题阅读入手，反复阅读10遍以上。
                    </li>
                </ul>
                <h3>第二阶段：强化复习阶段（4个月，9月—次年1月）</h3>
                <ul>
                    <li>复习注重框架知识点的归纳整理、历年真题的复习、内部讲义资料深度复习。</li>
                    <li>关注教育招生考试院公布的招生计划及招生简章信息（有转专业的同学，可根据最新出台政策调整报考方向，及早调整报考方向、报考院校）。
                        次年1月份：留意网上报名、网上缴费时间，顺利报考。
                    </li>
                </ul>
                <h3>第三阶段：冲刺阶段（2个月，次年1月至考前）</h3>
                <ul>
                    <li>错词本再利用、核心知识点、框架的梳理复习。</li>
                    <li>历年真题发挥重要作用，考前建议真题复习两遍，核心题型重复复习！</li>
                    <li>备考经验的储备，充分利用好一模、二模，总结每次考试的失与得，不断提升自己。</li>
                    <li>心态求稳，关注个人作息，注意饮食和身体。将备考状态调整到最佳。</li>
                </ul>

                <p><strong>春节假期是提弱补差的有利时机，充分利用好，可给春节后的冲刺复习锦上添花。春节后一个月是巩固复习最后关键阶段。</strong></p>
                <p class="margin20">附：2018年考试及录取时间表</p>
                <table>
                    <thead>
                        <tr>
                            <th>事项</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>网上补报名</td>
                            <td>3月1日</td>
                        </tr>
                        <tr>
                            <td>网上补缴费</td>
                            <td>3月7日</td>
                        </tr>
                        <tr>
                            <td>打印准考证</td>
                            <td>3月19日-25日</td>
                        </tr>
                        <tr>
                            <td>考试时间</td>
                            <td>3月24日-25日</td>
                        </tr>
                        <tr>
                            <td>成绩查询</td>
                            <td>4月25日</td>
                        </tr>
                        <tr>
                            <td>录取查询</td>
                            <td>5月21日</td>
                        </tr>
                        <tr>
                            <td>发放通知书</td>
                            <td>6月中旬起各校陆续发放</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
