<?php
/* @var $this ListsManageController */
/* @var $model Lists */
/* @var $form CActiveForm */
/* @var $parentID int */
?>
<div class="well" id="add-form">
	<h4>افزودن گزینه جدید</h4><br>
    <div class="alert hidden"></div>
	<?php $this->renderPartial("//layouts/_flashMessage"); ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'option-form-add',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'htmlOptions' => [
			'class' => 'form-inline'
		],
		'clientOptions' => array(
			'validateOnSubmit' => true
		)
	));
	echo CHtml::hiddenField('Lists[parent_id]',$parentID);
	?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>

		<div class="form-group buttons">
			<?php echo CHtml::ajaxSubmitButton('افزودن' ,array('addOption'),array(
                'dataType' => 'json',
				'success' => 'js:function(data){
					if(data.status){
						$("#Lists_title").val("");
						$("#list-options-grid").yiiGridView("update");
					}
					
					if(data.msg)
					    $(this).parents("form").find(".alert").removeClass("hidden alert-success alert-danger").
					        addClass(data.status?"alert-success":"alert-danger").html(data.msg);
				}'
			),array('class' => 'btn btn-success')); ?>
		</div>

	<?php $this->endWidget(); ?>
</div>

<div class="well hidden" id="edit-form">
	<h4>ویرایش گزینه <span id="option-title"></span></h4><br>
    <div class="alert hidden"></div>
	<?php $this->renderPartial("//layouts/_flashMessage"); ?>
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'option-form-edit',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
		'htmlOptions' => [
			'class' => 'form-inline'
		],
		'clientOptions' => array(
			'validateOnSubmit' => true
		)
	));
	echo CHtml::hiddenField('Lists[id]','');
	?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>

		<div class="form-group buttons">
			<?php echo CHtml::ajaxSubmitButton('ویرایش' ,array('editOption'),array(
                'dataType' => 'json',
				'success' => 'js:function(data){
					if(data.status){
						$(".cancel-edit").click();
						$("#list-options-grid").yiiGridView("update");
					}
					
					if(data.msg)
					    $(this).parents("form").find(".alert").removeClass("hidden alert-success alert-danger").
					        addClass(data.status?"alert-success":"alert-danger").html(data.msg);
				}'
			),array('class' => 'btn btn-success')); ?>
			<?php
			echo CHtml::button('انصراف', array(
				'class' => 'cancel-edit btn btn-default',
			))
			?>
		</div>

	<?php $this->endWidget(); ?>
</div>