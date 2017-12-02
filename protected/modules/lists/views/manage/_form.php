<?php
/* @var $this ListsManageController */
/* @var $model Lists */
/* @var $form CActiveForm */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?><?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lists-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('class'=>'form-control','size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'is_root'); ?>
		<?php echo $form->textField($model,'is_root',array('class'=>'form-control','size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'is_root'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'editable'); ?>
		<?php echo $form->textField($model,'editable',array('class'=>'form-control','size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'editable'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
