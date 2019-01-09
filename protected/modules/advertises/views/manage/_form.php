<?php
/* @var $this AdvertisesManageControllerController */
/* @var $model Advertises */
/* @var $form CActiveForm */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?><?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertises-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'banner'); ?>
		<?php echo $form->textField($model,'banner',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'banner'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'placement'); ?>
		<?php echo $form->textField($model,'placement',array('class'=>'form-control','size'=>2,'maxlength'=>2)); ?>
		<?php echo $form->error($model,'placement'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'expire_date'); ?>
		<?php echo $form->textField($model,'expire_date',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'expire_date'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('class'=>'form-control','size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
