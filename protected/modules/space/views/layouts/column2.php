<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">
            <div id="profile">
                <h4>个人信息</h4>
                <div class="content">
                    <center><?php echo $this->user->nickname;?></center>
                    <ul>
                        <li>
                            <b>积分</b>: <?php echo $this->user->credit;?>
                        </li>
                        <li>
                            <b>性别</b>: <?php echo $this->user->genderName;?>
                        </li>
                        <li>
                            <b>注册时间</b>: <?php echo $this->user->getRegDate("Y-m-d");?>
                        </li>
                        <li>
                            <b>更新时间</b>: <?php echo $this->user->getModifyDate("Y-m-d");?>
                        </li>
                    </ul>
                </div>
            </div>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>