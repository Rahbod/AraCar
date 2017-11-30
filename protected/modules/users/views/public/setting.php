<?php
/* @var $this UsersPublicController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<h3>تغییر کلمه عبور</h3>
<p class="description">جهت تغییر کلمه عبور خود فرم زیر را پر کنید.</p>

<?php $this->renderPartial('//partial-views/_flashMessage');?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'users-form',
        'action' => Yii::app()->createUrl('/users/public/setting'),
        'enableAjaxValidation'=>false,
    )); ?>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?php echo $form->passwordField($model,'oldPassword',array('placeholder'=>$model->getAttributeLabel('oldPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
            <?php echo $form->error($model,'oldPassword'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?php echo $form->passwordField($model,'newPassword',array('placeholder'=>$model->getAttributeLabel('newPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
            <?php echo $form->error($model,'newPassword'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?php echo $form->passwordField($model,'repeatPassword',array('placeholder'=>$model->getAttributeLabel('repeatPassword').' *','class'=>'form-control','maxlength'=>100,'value'=>'')); ?>
            <?php echo $form->error($model,'repeatPassword'); ?>
        </div>
    </div>

    <div class="buttons">
        <?php echo CHtml::submitButton('تغییر کلمه عبور',array('class'=>'btn btn-success')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>