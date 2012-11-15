<?php
$this->pageTitle = $model->title . $this->titleSeparator . Yii::app()->name;
$this->description = $model->getSummary(100);
$this->keywords  = $model->getKeywords();
$this->breadcrumbs = array(
    '教程'=>array('/wiki/index'),
    Lookup::item(Article::CATEGORY_TYPE, $model->category)=>$model->getCategoryUrl(),
    $model->title=>$model->getUrl(),
    '阅读全文'
);
?>
<div class="wiki-view">

<h1 id="title"><?php echo $model->title; ?></h1>

<div class="span-17">
    <div class="span-9 follow-bar">
        <?php
        if($model->isFollowed())
            echo CHtml::link(UserFav::getFollowCount($model->id)." 人关注",'#',array(
                'class'=>'follow',
                'title'=>'点击取消关注',
                'onClick'=>"addFav($model->id,".UserFav::TYPE_UNFOLLOW.");return false;"
            ));
        else
            echo CHtml::link(UserFav::getFollowCount($model->id)." 人关注",'#',array(
                'class'=>'unfollow',
                'title'=>'点击关注',
                'onClick'=>"addFav($model->id,".UserFav::TYPE_FOLLOW.");return false;"
            ));
        ?>
    </div>
    <div class="span-8 last thumb-bar">
        <?php echo CHtml::link(UserFav::getThumbUpCount($model->id),'#',array(
            'class'=>'thumb-up',
            'title'=>'支持',
                'onClick'=>"addFav($model->id,".UserFav::TYPE_THUMB_UP.");return false;"
        ));?>
        <?php echo CHtml::link(UserFav::getThumbDownCount($model->id),'#',array(
            'class'=>'thumb-down',
            'title'=>'不支持',
                'onClick'=>"addFav($model->id,".UserFav::TYPE_THUMB_DOWN.");return false;"
        ));?>
        <?php //echo CHtml::link("举报",'#',array('class'=>'report','title'=>'举报'));?>
    </div>
</div>


<div class="clear"></div>
<?php
if($model->hasTocs())
    echo $model->getTocsView();
$this->renderPartial('content',array('data'=>$model->content))
?>

</div><!-- wiki view -->

<hr />

<div class="comments" id="comments">
    <?php if($model->commentCount>=1): ?>
		<h2>
			共 <?php echo $model->commentCount . ' 条评论' ; ?>
		</h2>

		<?php $this->renderPartial('_comments',array(
			'article'=>$model,
			'comments'=>$model->comments,
		)); ?>
	<?php endif; ?>

    <h2>发表评论</h2>
    <?php if(!Yii::app()->user->isGuest):?>
    <?php $this->renderPartial('_form_comment',array(
        'model'=>$comment,
        'article'=>$model
    )); ?>
    <?php else:?>
    <div class="flash-notice">
        <center>
            请先 <?php echo CHtml::link('登录',array('user/login','returnUrl'=>  urlencode($model->getUrl().'#comment-form')))?> 或 <?php echo CHtml::link('注册',array('user/register'))?>
        </center>
    </div>
    <?php endif;?>
</div><!-- wiki comments-->
<?php
Yii::app()->getClientScript()->registerScript("sub-title",<<<EOS
      toTop = "<a id=\"toTop\" href=\"#title\">¶</a>"
      $(".wiki-view .content .sub-title").hover(function(){
          $(this).append(toTop);
          $("#toTop").attr("href",'#'+$(this).attr('id'));
      },function(){
        $("#toTop").remove();
      });
EOS
);

Yii::app()->getClientScript()->registerScript("sub-title",<<<EOS
    function addFav(id,type){
        $.ajax({
            url:'{$this->createUrl('wiki/fav')}',
            type:'post',
            data:{'id':id,'type':type},
            dataType:'json',
            success:function(rs){
                if(rs.status == -2)
                    location.href='{$this->createUrl('user/login',array('returnUrl'=>  urlencode($model->url)))}';
                else
                    location.reload();
            }
        });
    }
EOS
        ,  CClientScript::POS_BEGIN
);
?>