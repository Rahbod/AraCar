<div class="comment-widget <?= Yii::app()->language != 'fa'?'en':'' ?>" id="<?php echo $this->id?>">
<?php
//    echo '<div class="comment-form-outer col-lg-4 col-md-4 col-sm-5 col-xs-12" id="comment-form" >';
    echo '<div class="comment-form-outer" id="comment-form" >';
    if($this->showPopupForm === true)
    {
        if($this->registeredOnly === false || Yii::app()->user->isGuest === false)
        {
            Yii::app()->controller->renderPartial('//partial-views/_loading');
//            echo '<h3><span>'.Yii::t($this->_config['translationCategory'], 'Send '.ucfirst($this->_config['moduleObjectName'])).'</span></h3>';
            echo "<div class='comment-form' id=\"addCommentDialog-$this->id\">";
            $this->widget('comments.widgets.ECommentsFormWidget', array(
                'model' => $this->model,
            ));
            echo "</div>";
        }
    }
    if($this->registeredOnly === true && Yii::app()->user->isGuest === true)
    {
        // @todo change login and signup links
        echo Yii::t($this->_config['translationCategory'], 'To add any '.$this->_config['moduleObjectName'].', you should sign up first.');
        echo '&nbsp;<a data-toggle="modal" href="'.Yii::app()->createUrl('/login').'">'.Yii::t($this->_config['translationCategory'], 'Log In').'</a>';
        echo '&nbsp;'.Yii::t($this->_config['translationCategory'],'or').'&nbsp;';
        echo '<a href="'.Yii::app()->createUrl('/register').'">'.Yii::t($this->_config['translationCategory'], 'Sign Up.').'</a>';
    }
    echo "</div>";
//    echo '<div class="comments-list-outer col-lg-8 col-md-8 col-sm-7 col-xs-12">';
    echo '<div class="comments-list-outer comments-box">';
    //echo '<h3><span>'.Yii::t($this->_config['translationCategory'], ucfirst($this->_config['moduleObjectName']).'s List').'</span></h3>';
    $this->render('ECommentsWidgetComments', array('comments' => $comments));
    echo '</div>';
?>
</div>
