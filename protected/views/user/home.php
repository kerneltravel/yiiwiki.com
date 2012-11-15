<?php
$this->pageTitle = $name.'的个人资料 - ' . Yii::app()->name;
$this->breadcrumbs = array(
    '个人中心'
);
?>
<h1>
    <?php echo $name.'的个人资料';?>
</h1>

<div class="profile">
    <ul>
        <li>
            <b>姓名</b>: <?php echo $model->nickname;?>
        </li>
        <li>
            <b>积分</b>: <?php echo $model->credit;?>
        </li>
        <li>
            <b>性别</b>: <?php echo $model->genderName;?>
        </li>
        <li>
            <b>邮箱</b>: <?php echo $model->email;?>
        </li>
        <li>
            <b>发表文章</b>: <?php echo $model->articleCount;?>
        </li>
        <li>
            <b>发表回复</b>: <?php echo $model->commentCount;?>
        </li>
        <li>
            <b>注册时间</b>: <?php echo $model->getRegDate("Y-m-d");?>
        </li>
        <li>
            <b>更新时间</b>: <?php echo $model->getModifyDate("Y-m-d");?>
        </li>
    </ul>
</div>