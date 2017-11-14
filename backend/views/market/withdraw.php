<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', '提现历史');

?>
<div class="user-view">

    <h1>提现记录</h1>
<ul>
<?php 
$str = '';
foreach($model as $key=>$val)
{
    $str .= "<li><div>$val->withdraw_id</div><div>$val->fee</div><div>$val->info</div><div>".date('Y-m-d H:i:s', $val->create_time)."</div>";
}
echo $str;
?>
</ul>

<?= LinkPager::widget(['pagination' => $pages]); ?>



</div>
