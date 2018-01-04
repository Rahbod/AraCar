<?php
/* @var $this CarManageController */
/* @var $model CarAlerts */
/* @var $form CActiveForm */
/* @var $images UploadedFiles|[] */
?>
<?php $this->renderPartial("//partial-views/_flashMessage"); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brands-form',
	'htmlOptions' => ['class' => 'inline-form sell-form'],
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-push-3 col-md-push-3 col-sm-push-3">
		<p class="form-title">
			شما نیز با تکمیل فرم زیر خودرو را به سرعت بفروشید
		</p>
		<?php
		echo $form->errorSummary($model);
		?>
		<div class="row">
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php echo CHtml::dropDownList('brand_id', isset($_POST['brand_id'])?$_POST['brand_id']:'', Brands::getList(),array(
                    'class'=>'form-control select-picker load-list',
                    'data-live-search' => true,
                    'data-url'=>$this->createUrl('/car/public/getBrandModels'),
                    'data-target' => '#CarAlerts_model_id',
                    'prompt' => 'برند',
                )); ?>
                <?php echo $form->error($model,'brand_id'); ?>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php echo $form->dropDownList($model,'model_id', isset($_POST['brand_id'])?Models::getList($_POST['brand_id']):[],array(
                    'class'=>'form-control select-picker load-list',
                    'data-live-search' => true,
                    'data-url'=>$this->createUrl('/car/public/getModelYears'),
                    'data-target' => '#CarAlerts_from_year',
                    'data-target2' => '#CarAlerts_to_year',
                    'data-target3' => '#CarAlerts_from_price',
                    'data-target4' => '#CarAlerts_to_price',
                    'disabled'=>isset($_POST['brand_id'])?false:'disabled',
                    'prompt' => $model->getAttributeLabel('model_id'),
                )); ?>
                <?php echo $form->error($model,'model_id'); ?>
			</div>
			<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->dropDownList($model,'from_year', $model->model_id?$model->model->getYears():[],array(
                    'class'=>'form-control select-picker',
                    'data-live-search' => true,
                    'disabled'=>$model->model_id?false:'disabled',
                    'prompt' => $model->getAttributeLabel('from_year'),
                )); ?>
                <?php echo $form->error($model,'from_year'); ?>
			</div>
			<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->dropDownList($model,'to_year', $model->model_id?$model->model->getYears():[],array(
                    'class'=>'form-control select-picker',
                    'data-live-search' => true,
                    'disabled'=>$model->model_id?false:'disabled',
                    'prompt' => $model->getAttributeLabel('to_year'),
                )); ?>
                <?php echo $form->error($model,'to_year'); ?>
			</div>
			<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->textField($model,'from_price', array(
                    'class'=>'form-control digitFormat',
                    'maxLength'=>3,
                    'disabled'=>$model->model_id?false:'disabled',
                    'placeholder' => $model->getAttributeLabel('from_price').' (میلیون تومان)',
                )); ?>
                <?php echo $form->error($model,'from_price'); ?>
			</div>
			<div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php echo $form->textField($model,'to_price', array(
                    'class'=>'form-control digitFormat',
					'maxLength'=>3,
                    'disabled'=>$model->model_id?false:'disabled',
                    'placeholder' => $model->getAttributeLabel('to_price').' (میلیون تومان)',
                )); ?>
                <?php echo $form->error($model,'to_price'); ?>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button type="submit" class="btn btn-primary pull-left"><?= $model->isNewRecord?'ثبت آگهی':'ویرایش آگهی' ?></button>
			</div>
		</div>
	</div>
<?php $this->endWidget() ?>

<?php
Yii::app()->clientScript->registerScript("sell-js","
    $('body').on('change', '.load-list', function(){
        var url = $(this).data('url');
        var target = $($(this).data('target'));
        var target2 = $($(this).data('target2'));
        var target3 = $($(this).data('target3'));
        var target4 = $($(this).data('target4'));
        var id = $(this).val();
        target.attr('disabled', 'disabled');
        target2.attr('disabled', 'disabled');
        target3.attr('disabled', 'disabled');
        target4.attr('disabled', 'disabled');
        $.ajax({
            url: url,
            type: 'GET',
            data:{id: id},
            dataType: 'json',
            success: function(data){
                if(data.status){
                    target.find('option:not(:first-of-type)').remove();
                    target2.find('option:not(:first-of-type)').remove();
                    for (var i = 0; i < data.list.length; i++) {
                      target.append($('<option>', {
                        value: data.list[i].id,
                        text: data.list[i].title
                      }));
                      
                      target2.append($('<option>', {
                        value: data.list[i].id,
                        text: data.list[i].title
                      }));
                    }
                    
                    target.attr('disabled', false); 
                    target.selectpicker('refresh');
                    
                    target2.attr('disabled', false); 
                    target2.selectpicker('refresh');
                    
                    target3.attr('disabled', false);
			        target4.attr('disabled', false);
                }else
                    alert(data.message);
            }
        });
    });
");
