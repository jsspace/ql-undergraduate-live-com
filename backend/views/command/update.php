<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Command */

$this->title = '更新需求';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Commands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="command-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<script type="text/javascript">
    $('#command-user_id').attr('disabled', 'disabled');
    $('#command-content').attr('disabled', 'disabled');
</script>
