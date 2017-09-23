<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model backend\models\User */


?>
<div class="user-view">

    <h1>订单记录</h1>
<ul>
<?php 
$str = '';
foreach($model as $key=>$val)
{
    $str .= "<li><div>$val->order_sn</div><div>$val->pay_fee</div><div>$val->user_id</div><div>".date('Y-m-d H:i:s', $val->add_time)."</div>";
}
echo $str;
?>
</ul>

<?= LinkPager::widget(['pagination' => $pages]); ?>



</div>
