<?php
/* @var $this CarManageController */
/* @var $model Cars */
/* @var $form CActiveForm */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cars-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'update_date'); ?>
		<?php echo $form->textField($model,'update_date',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'update_date'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'expire_date'); ?>
		<?php echo $form->textField($model,'expire_date',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'expire_date'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'brand_id'); ?>
		<?php echo $form->textField($model,'brand_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'brand_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'model_id'); ?>
		<?php echo $form->textField($model,'model_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'model_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'room_color_id'); ?>
		<?php echo $form->textField($model,'room_color_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'room_color_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'body_color_id'); ?>
		<?php echo $form->textField($model,'body_color_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'body_color_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'body_state_id'); ?>
		<?php echo $form->textField($model,'body_state_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'body_state_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'state_id'); ?>
		<?php echo $form->textField($model,'state_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'state_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->textField($model,'city_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'fuel_id'); ?>
		<?php echo $form->textField($model,'fuel_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'fuel_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'gearbox_id'); ?>
		<?php echo $form->textField($model,'gearbox_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'gearbox_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'car_type_id'); ?>
		<?php echo $form->textField($model,'car_type_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'car_type_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'plate_type_id'); ?>
		<?php echo $form->textField($model,'plate_type_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'plate_type_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'purchase_type_id'); ?>
		<?php echo $form->textField($model,'purchase_type_id',array('class'=>'form-control','size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'purchase_type_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'purchase_details'); ?>
		<?php echo $form->textField($model,'purchase_details',array('class'=>'form-control','size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'purchase_details'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'distance'); ?>
		<?php echo $form->textField($model,'distance',array('class'=>'form-control','size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'distance'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('class'=>'form-control','size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'visit_district'); ?>
		<?php echo $form->textField($model,'visit_district',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'visit_district'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>
