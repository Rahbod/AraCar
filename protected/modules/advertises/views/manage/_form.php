<?php
/* @var $this AdvertisesManageController */
/* @var $model Advertises */
/* @var $form CActiveForm */
/* @var $banner UploadedFiles */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'advertises-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>


    <div class="form-group">
        <?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model,'type', $model->typeLabels,array('class'=>'form-control', 'id' => 'type-trigger')); ?>
        <?php echo $form->error($model,'type'); ?>
    </div>

    <div class="form-group banner-field">
        <?php echo $form->labelEx($model,'banner'); ?>
        <?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
            'id' => 'uploaderBanner',
            'model' => $model,
            'name' => 'banner',
            'maxFiles' => 1,
            'maxFileSize' => 0.5, //MB
            'url' => $this->createUrl('upload'),
            'deleteUrl' => $this->createUrl('deleteUpload'),
            'acceptedFiles' => '.jpg, .jpeg, .png',
            'serverFiles' => $banner,
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
        <?php echo $form->error($model,'banner'); ?>
        <div class="uploader-message error"></div>
    </div>

	<div class="form-group banner-field">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->urlField($model,'link',array('class'=>'form-control ltr','size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="form-group script-field">
		<?php echo $form->labelEx($model,'script'); ?>
		<?php echo $form->textArea($model,'script',array('class'=>'form-control ltr','rows' => 5)); ?>
		<?php echo $form->error($model,'script'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('class'=>'form-control','size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'placement'); ?>
		<?php echo $form->dropDownList($model,'placement', $model->getPlacementLabels(false), array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'placement'); ?>
	</div>

<!--	<div class="form-group">-->
<!--		--><?php //echo $form->labelEx($model,'create_date'); ?>
<!--		--><?php //echo $form->textField($model,'create_date',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
<!--		--><?php //echo $form->error($model,'create_date'); ?>
<!--	</div>-->
<!---->
<!--	<div class="form-group">-->
<!--		--><?php //echo $form->labelEx($model,'expire_date'); ?>
<!--		--><?php //echo $form->textField($model,'expire_date',array('class'=>'form-control','size'=>20,'maxlength'=>20)); ?>
<!--		--><?php //echo $form->error($model,'expire_date'); ?>
<!--	</div>-->

	<div class="form-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', $model->statusLabels,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>


<?php
Yii::app()->clientScript->registerScript('type-trigger','
    var typeval = $("#type-trigger").val();
    if(typeval == 1){ // script
        $(".banner-field").fadeOut();
        $(".script-field").fadeIn();
    }else if(typeval == 2){ // banner
        $(".banner-field").fadeIn();
        $(".script-field").fadeOut();
    }
        
    $("body").on("change", "#type-trigger", function(){
        var typeval = $("#type-trigger").val();
        if(typeval == 1){ // script
            $(".banner-field").fadeOut();
            $(".script-field").fadeIn();
        }else if(typeval == 2){ // banner
            $(".banner-field").fadeIn();
            $(".script-field").fadeOut();
        }
    });
');