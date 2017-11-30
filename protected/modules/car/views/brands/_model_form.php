<?php
/* @var $this CarBrandsController */
/* @var $model Brands */
/* @var $brand_id integer */
/* @var $form CActiveForm */
/* @var $image UploadedFiles */

if($model->isNewRecord)
    $clientOptions = array(
        'validateOnSubmit' => true,
        'afterValidate' => 'js:function(form ,data ,hasError){
            if(!hasError)
            {
                var loading = form.find(".loading-container");
                var url = form.attr("action");
                submitAjaxForm(form ,url ,loading ,"if(html.status){ if(typeof html.url == \'undefined\') location.reload(); else window.location = html.url;}");
            }
        }'
    );
else
    $clientOptions = array(
        'validateOnSubmit' => true
    );
?>
<?php $this->renderPartial('//layouts/_loading') ?>
<?php $this->renderPartial('//layouts/_flashMessage') ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>($model->isNewRecord?'create-model-form':'update-model-form'),
    'action' => $model->isNewRecord?array('brands/modelAdd?ajax=create-model-form'):array('brands/modelEdit/'.$model->id),
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => $clientOptions
));
if($model->isNewRecord)
    echo CHtml::hiddenField('Models[brand_id]',$brand_id);
?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'slug'); ?> (انگلیسی)
		<?php echo $form->textField($model,'slug',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

    <div class="form-group">
		<?php echo $form->labelEx($model,'body_type_id'); ?>
		<?php echo $form->dropDownList($model,'body_type_id', Lists::getList('body_types'),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'body_type_id'); ?>
	</div>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>