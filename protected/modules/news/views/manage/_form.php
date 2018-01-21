<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $form CActiveForm */
/* @var $image [] */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?= $this->renderPartial("//partial-views/_loading");?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->dropDownList($model,'category_id',NewsCategories::model()->adminSortList(),array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class='form-group'>
		<?php echo $form->labelEx($model,'image', array('class'=>'control-label')); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderFile',
			'model' => $model,
			'name' => 'image',
			'maxFiles' => 1,
			'maxFileSize' => 2, //MB
			'url' => $this->createUrl('/news/manage/upload'),
			'deleteUrl' => $this->createUrl('/news/manage/deleteUpload'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
			'serverFiles' => $image,
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
                    this.removeFile(file);
                }
            ',
		)); ?>
		<?php echo $form->error($model,'image'); ?>
		<div class="uploader-message error"></div>
	</div>
	<div class="clearfix"></div>
	<div class='form-group'>
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model, 'title',array('maxlength'=>255,'class' => 'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class='form-group'>
		<?php echo $form->labelEx($model,'sub_title'); ?>
		<?php echo $form->textField($model, 'sub_title',array('maxlength'=>255, 'class' => 'form-control')); ?>
		<?php echo $form->error($model,'sub_title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo $form->textArea($model,'summary',array('form-groups'=>6,'style'=>'width:100%','maxlength'=>2000, 'class' => 'form-control')); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php
		$this->widget("ext.ckeditor.CKEditor",array(
			'model' => $model,
			'attribute' => 'body'
		));
		?>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',$model->statusLabels,array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'formTags'); ?>
		<?php
		$this->widget("ext.tagIt.tagIt",array(
			'model' => $model,
			'attribute' => 'formTags',
			'suggestType' => 'json',
			'suggestUrl' => Yii::app()->createUrl('/courses/tags/list'),
			'data' => $model->formTags
		));
		?>
		<?php echo $form->error($model,'formTags'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ثبت' : 'ذخیره',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->