<div id="header">
    <div id="top-wrap">
        <div id="top">
            <div class="right">
                <?php if(Yii::app()->user->isGuest):?>
                欢迎您，请 <?php echo CHtml::link('登录',array('user/login'));?>
                · <?php echo CHtml::link('注册',array('user/register'));?>
                · <?php echo CHtml::link('找回密码',array('user/findPassword'));?>
                <?php else:?>
                欢迎您，<?php echo Yii::app()->user->name;?>
                 · <?php echo CHtml::link('个人中心',array('user/home'));?>
                 · <?php echo CHtml::link('退出',array('user/logout'));?>
                <?php endif;?>
            </div>
            <div class="left">
                <?php echo CHtml::link('交流论坛','http://www.yiichina.org/forum/',array('target'=>'_blank'));?>
                 | <?php echo CHtml::link('Yii官方网站','http://www.yiiframework.com',array('target'=>'_blank'));?>
            </div>
        </div><!-- top -->
    </div>
    <div id="logo-wrap">
        <div id="logo">
             <?php echo CHtml::link('Yii中文百科',array('/')); ?>
        </div>
    </div>
    <div id="mainmenu-wrap">
        <div id="mainmenu">
            <!-- div id="mainmenu-search">
                <?php echo CHtml::beginForm(array('/site/search'),'get',array(
                    'onSubmit'=>"if($('#SearchForm_keywords').val() == ''){alert('请输入要搜索的内容');return false;}else {return true;}",
                ));?>
                <?php echo CHtml::textField('SearchForm[keywords]',$_GET['SearchForm']['keywords']);?>
                <?php echo CHtml::submitButton('',array('id'=>'search'));?>
                <?php echo CHtml::endForm();?>
            </div -->
            <?php $this->widget('zii.widgets.CMenu',array(
                'firstItemCssClass'=>'first',
                'items'=>$this->menu,
            )); ?>
        </div><!-- mainmenu -->
    </div>
</div><!-- header -->