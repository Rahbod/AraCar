<?php 
/**
 * @var $newComment Comment
 * @var $form CActiveForm
 */
?>

<div class="form comment-form-container">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>$this->id,
    'htmlOptions'=>array(
        'class'=>'comment-box'
    )
)); ?>
    <?php 
        echo $form->hiddenField($newComment, 'owner_name'); 
        echo $form->hiddenField($newComment, 'owner_id'); 
        echo $form->hiddenField($newComment, 'parent_comment_id', array('class'=>'parent_comment_id'));
    ?>
    <?php if(Yii::app()->user->isGuest == true):?>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($newComment,'user_name', array('size'=>40 ,'class'=>'form-control','placeholder' => $newComment->getAttributeLabel('user_name'))); ?>
            <?php echo $form->error($newComment,'user_name'); ?>
        </div>
        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?php echo $form->textField($newComment,'user_email', array('size'=>40,'class'=>'form-control','placeholder' => $newComment->getAttributeLabel('user_email'))); ?>
            <?php echo $form->error($newComment,'user_email'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="field-newscomment-content">
                <?php //echo $form->labelEx($newComment, 'comment_text'); ?>
                <?php echo $form->textArea($newComment, 'comment_text', array('placeholder'=>'نظر خود را بنویسید...','cols' => 60, 'rows' => 5,'class'=>'form-control')); ?>
                <?php echo $form->error($newComment, 'comment_text'); ?>
            </div>
        </div>
    </div>

    <?php if($this->useCaptcha === true && extension_loaded('gd')): ?>
        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div>
                <div class="captcha-box">
                    <?php $this->widget('CCaptcha', array(
                        'captchaAction'=>CommentsModule::CAPTCHA_ACTION_ROUTE,
                        'showRefreshButton' => true
                    )); ?>
                </div>
                <?php echo $form->textField($newComment,'verifyCode',array('class' => 'form-control','placeholder' => $newComment->getAttributeLabel('verifyCode'))); ?>
                
            </div>
            <div class="hint">
                <?php echo Yii::t($this->_config['translationCategory'], 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.');?>
            </div>
            <?php echo $form->error($newComment, 'verifyCode'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="btn-group pull-left">
            <?php echo CHtml::button(Yii::t($this->_config['translationCategory'],'Add '.$this->_config['moduleObjectName']),
                array('data-url'=>Yii::app()->createAbsoluteUrl($this->postCommentAction),'class'=> 'btn comment-submit comment-submit-form-btn'));
            ?>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
