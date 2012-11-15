<?php foreach($comments as $comment): ?>
<div class="comment" id="c<?php echo $comment->id; ?>">

	<div class="author">
        <?php echo CHtml::link("#{$comment->id}", $comment->getUrl($article), array(
            'class'=>'cid right',
            'title'=>'评论永久链接',
        )); ?>
		<?php echo $comment->authorLink; ?> 发表于:
		<span class='time'>
            <?php echo $comment->getDate(); ?>
        </span>
	</div>
    <hr />
	<div class="content">
		<?php
        $this->renderPartial('content',array('data'=>$comment->content))
        ?>
	</div>
    <?php
    if($comment->user_id == Yii::app()->user->id):
    ?>
    <div class="operations">
        <?php echo CHtml::link("修改",array('updateComment','id'=>$comment->id),array('class'=>'update'));?>
        <?php echo CHtml::link("删除",array('deleteComment','id'=>$comment->id),array(
            'confirm'=>'确定删除此评论？',
            'ajax'=>array(
                'url'=>'js:$(this).attr("href")',
                'type'=>'post',
                'dataType'=>'json',
                'success'=>'function(rs){
                    if(rs.status==0){
                        alert(rs.message);
                    }else if(rs.status ==1){
                        location.reload()
                    }
                }',
            ),
            'class'=>'delete'
        ));?>
    </div>
    <?php endif;?>
</div><!-- comment -->
<?php endforeach; ?>