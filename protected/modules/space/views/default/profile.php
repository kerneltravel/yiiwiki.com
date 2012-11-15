<?php
$this->pageTitle = '个人资料'.$this->titleSeparator.$this->user->nickname;
?>

<h4>基本信息</h4>

<div class="profile prepend-1 append-1">

    <ul>
        <li>
            <b>姓名</b>: <?php echo $this->user->nickname;?>
        </li>
        <li>
            <b>积分</b>: <?php echo $this->user->credit;?>
        </li>
        <li>
            <b>性别</b>: <?php echo $this->user->genderName;?>
        </li>
        <li>
            <b>邮箱</b>: <?php echo $this->user->email;?>
        </li>
        <li>
            <b>发表文章</b>: <?php echo $this->user->articleCount;?>
        </li>
        <li>
            <b>发表回复</b>: <?php echo $this->user->commentCount;?>
        </li>
        <li>
            <b>注册时间</b>: <?php echo $this->user->getRegDate("Y-m-d");?>
        </li>
        <li>
            <b>更新时间</b>: <?php echo $this->user->getModifyDate("Y-m-d");?>
        </li>
    </ul>
</div>