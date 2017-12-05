<?php
/* @var $this CarBrandsController */
/* @var $model ModelDetails */
/* @var $model_id integer */
/* @var $form CActiveForm */
/* @var $images UploadedFiles */

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
<?php $this->renderPartial('//partial-views/_flashMessage') ?>
<?php $this->renderPartial('//partial-views/_loading') ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>($model->isNewRecord?'create-model-detail-form':'update-model-detail-form'),
    'action' => $model->isNewRecord?$this->createUrl('modelDetailAdd').'?ajax=create-model-detail-form':$this->createUrl('modelDetailEdit').'/'.$model->id.'?ajax=update-model-detail-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => $clientOptions
));
if(!!$model->isNewRecord)
    echo CHtml::hiddenField('ModelDetails[model_id]',$model_id);
?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'product_year'); ?>
        <?php echo $form->textField($model,'product_year',array('class'=>'form-control','size'=>10,'maxlength'=>4, 'minlength'=>4)); ?>
        <small>مثال: 1396 یا 2017</small>
        <?php echo $form->error($model,'product_year'); ?>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'images'); ?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => !$model->isNewRecord?'uploaderImage-update':'uploaderImage-insert',
			'model' => $model,
			'name' => 'images',
			'maxFiles' => 5,
			'maxFileSize' => 2, //MB
			'url' => Yii::app()->createUrl('/car/brands/uploadModelImage'),
			'deleteUrl' => Yii::app()->createUrl('/car/brands/deleteUploadModelImage'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
			'serverFiles' => !$model->isNewRecord?$images:[],
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
		<?php echo $form->error($model,'images'); ?>
		<div class="uploader-message error"></div>
	</div>
    <div class="form-group well">
        <h4><?php echo $form->labelEx($model,'details'); ?></h4>
        <?php
        foreach(ModelDetails::$detailFields as $group => $items):
            ?>
            <div class="row">
                <?php
                foreach($items as $item):
                ?>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?php echo CHtml::label($item['title'],$item['name']) ?>
                        <?php echo CHtml::textField("ModelDetails[details][{$group}][{$item['name']}]",$model->getDetail($group,$item['name']),array('class' => 'form-control')) ?>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
            <hr>
            <?php
        endforeach;
        ?>
    </div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'افزودن' : 'ویرایش',array('class' => 'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>