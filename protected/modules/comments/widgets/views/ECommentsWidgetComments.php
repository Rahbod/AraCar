<?php if(count($comments) > 0):?>
    <ul class="comments-list">
        <?php foreach($comments as $comment):?>
            <li class="comment" id="comment-<?php echo $comment->comment_id; ?>">
                <div class="comment-pic">
                    <?php
                    if($comment->avatarLink && !empty($comment->avatarLink) && file_exists($comment->avatarLink))
                        echo '<img src="'.$comment->avatarLink.'" >';
                    else
                        echo '<span class="svg-icons user"></span>';
                    ?>
                </div>
                <div class="comment-details">
                    <span class="comment-title"><?php echo $comment->userName;?></span>
                    •
                    <span class="comment-date"><?php echo JalaliDate::differenceTime($comment->create_time);?></span>
                    <div class="comment-text"><?php echo $comment->comment_text;?></div>
                    <?php if($this->adminMode === true):?>
                        <div class="admin-panel">
                            <?php if($this->_config['premoderate'] === true && ($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROWED)) {
                                echo CHtml::link(Yii::t($this->_config['translationCategory'], 'approve'), Yii::app()->urlManager->createUrl(
                                    CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                                ), array('class'=>'btn btn-success btn-xs approve'));
                            }?>
                            <?php echo CHtml::link(Yii::t($this->_config['translationCategory'], 'delete'), Yii::app()->urlManager->createUrl(
                                CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                            ), array('class'=>'btn btn-danger btn-xs delete'));?>
                        </div>
                    <?php endif; ?>
                    <span class="comment-action-buttons">
                        <?php
                        if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false))
                        {
                            echo CHtml::link(Yii::t($this->_config['translationCategory'], 'Reply'), '#reply-'.$comment->comment_id, array(
                                'data-comment-id'=>$comment->comment_id,
                                'class'=>'comment-reply-link comment-reply collapsed add-comment',
                                'data-toggle' => 'collapse',
                                'data-parent'=>'#comment-'.$comment->comment_id
                            ));
                            echo "<div class='comment-form comment-form-outer collapse' id='reply-".$comment->comment_id."'>";
                            Yii::app()->controller->renderPartial('//partial-views/_loading');
                            $this->widget('comments.widgets.ECommentsFormWidget', array(
                                'model' => $this->model,
                            ));
                            echo "</div>";
                        }
                        ?>
                        <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));?>
<!--                        <a class="comment-reply-link comment-reply" href="#" data-action="reply" data-comment-id="2939">پاسخ دادن به این نظر</a>-->
                    </span>
                </div>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t($this->_config['translationCategory'], 'No '.$this->_config['moduleObjectName'].'s');?></p>
<?php endif;
?>
<script>
function checkRtl( character ) {
    var RTL = ['ا','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ه','ی'];
    return RTL.indexOf( character ) > -1;
}

function checkChar( character ) {
    if (character.match(/\s/) || character.match(/[0-9-!@#$%^&()_+|~=`{}\[\]:";\'<>?,.\/]/))
        return true;
    else
        return false;
}
var pTags = $(".comments-list").find("p");
pTags.each(function(){
    var firstChar = $(this).text().trim().substr(2,1);
    console.log(firstChar);
    var $i=3;
    while(checkChar(firstChar) && $i < $(this).text().trim().length)
    {
        firstChar = $(this).text().trim().substr($i,1);
        console.log(firstChar);
        $i++;
    }
    console.log(checkRtl(firstChar));
    if( checkRtl(firstChar) ) {
        $(this).removeClass("ltr").addClass("rtl");
    } else {
        $(this).removeClass("rtl").addClass("ltr");
    }
});
</script>

