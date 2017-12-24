<?php
/* @var $this UsersManageController */
/* @var $model Users */
/* @var $form CActiveForm */
/* @var $avatar array */
?>

<div class="form">

<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">فیلد های <span class="required">*</span>دار اجباری هستند.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'dealership_name'); ?>
		<?php echo $form->textField($model,'dealership_name',array('maxlength'=>50,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'dealership_name'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'first_name'); ?> (مدیر)
		<?php echo $form->textField($model,'first_name',array('maxlength'=>50,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'last_name'); ?> (مدیر)
		<?php echo $form->textField($model,'last_name',array('maxlength'=>50,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'mobile'); ?>
        <?php echo $form->textField($model,'mobile',array('maxlength'=>11,'class' => 'form-control')); ?>
        <?php echo $form->error($model,'mobile'); ?>
    </div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('maxlength'=>11,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('maxlength'=>1000,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'repeatPassword'); ?>
		<?php echo $form->passwordField($model,'repeatPassword',array('size'=>60,'maxlength'=>100,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'repeatPassword'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'avatar'); ?>
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderFile',
            'model' => $model,
            'name' => 'avatar',
            'maxFiles' => 1,
            'maxFileSize' => 2, //MB
            'url' => $this->createUrl('/users/manage/upload'),
            'deleteUrl' => $this->createUrl('/users/manage/deleteUpload'),
            'acceptedFiles' => '.jpeg, .jpg, .png, .gif',
            'serverFiles' => $avatar,
            'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.state == "ok")
				{
					{serverName} = responseObj.fileName;
				}else if(responseObj.state == "error"){
					console.log(responseObj.msg);
				}
		',
        )); ?>
    </div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->