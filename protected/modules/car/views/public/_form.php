<?php
/* @var $this CarManageController */
/* @var $model Cars */
/* @var $form CActiveForm */
/* @var $images UploadedFiles|[] */
$carTypesList = Lists::getList('car_types');
if(!$model->purchase_type_id)
    $model->purchase_type_id = 0;
if(!$model->car_type_id)
    $model->car_type_id = key($carTypesList);
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
<?php
echo $form->errorSummary($model);
?>
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<p class="form-title">
		</p>
		<div class="row month-statistics">
			<div class="pull-right month-vector"></div>
			<div class="pull-right">
				<h5 class="text-blue"><b><?= Cars::getMonthlySell() ?></b></h5>
				<small>خودرو در ماه گذشته</small>
				<br>
				<small>ثبت شد!</small>
			</div>
		</div>
		<div class="row day-statistics">
			<div class="pull-right day-vector"></div>
			<div class="pull-right">
				<h5 class="text-blue"><b><?= Cars::getDailySell() ?></b></h5>
				<small>خودرو در 24 ساعت گذشته</small>
				<br>
				<small>ثبت شد!</small>
			</div>
		</div>
		<div class="form-group">
			<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
				'id' => 'uploaderImages',
				'model' => $model,
				'name' => 'images',
				'containerClass' => 'image-uploader',
				'dictDefaultMessage' => 'تصاویر خودروی خود را بکشید و در کادر رها کنید.',
				'maxFiles' => $adImageCount,
				'maxFileSize' => 1, //MB
				'url' => Yii::app()->createUrl('/car/public/upload'),
				'deleteUrl' => Yii::app()->createUrl('/car/public/deleteUpload'),
				'acceptedFiles' => '.jpg, .jpeg, .png',
				'serverFiles' => $images,
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
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<p class="form-title">
			شما نیز با تکمیل فرم زیر خودرو را به سرعت بفروشید
		</p>
		<div class="row">
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'brand_id', Brands::getList(),array(
                    'class'=>'form-control select-picker load-list',
                    'data-live-search' => true,
                    'data-url'=>$this->createUrl('/car/public/getBrandModels'),
                    'data-target' => '#Cars_model_id',
                    'prompt' => $model->getAttributeLabel('brand_id'),
                )); ?>
                <?php echo $form->error($model,'brand_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'model_id', $model->brand_id?Models::getList($model->brand_id):[],array(
                    'class'=>'form-control select-picker load-list',
                    'data-live-search' => true,
                    'data-url'=>$this->createUrl('/car/public/getModelYears'),
                    'data-target' => '#Cars_creation_date',
                    'disabled'=>$model->brand_id?false:'disabled',
                    'prompt' => $model->getAttributeLabel('model_id'),
                )); ?>
                <?php echo $form->error($model,'model_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'creation_date', $model->model_id?$model->model->getYears():[],array(
                    'class'=>'form-control select-picker',
                    'data-live-search' => true,
                    'disabled'=>$model->model_id?false:'disabled',
                    'prompt' => $model->getAttributeLabel('creation_date'),
                )); ?>
                <?php echo $form->error($model,'creation_date'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'fuel_id', Lists::getList('fuel_types'),array(
                    'class'=>'form-control select-picker',
                    'prompt' => $model->getAttributeLabel('fuel_id'),
                )); ?>
                <?php echo $form->error($model,'fuel_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'gearbox_id', Lists::getList('gearbox_types'),array(
                    'class'=>'form-control select-picker',
                    'prompt' => $model->getAttributeLabel('gearbox_id'),
                )); ?>
                <?php echo $form->error($model,'gearbox_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'body_state_id', Lists::getList('body_states'),array(
                    'class'=>'form-control select-picker',
                    'prompt' => $model->getAttributeLabel('body_state_id'),
                )); ?>
                <?php echo $form->error($model,'body_state_id'); ?>
			</div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'body_color_id', Lists::getList('colors'),array(
                    'class'=>'form-control select-picker',
                    'data-live-search' => true,
                    'prompt' => $model->getAttributeLabel('body_color_id'),
                )); ?>
                <?php echo $form->error($model,'body_color_id'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'room_color_id', Lists::getList('colors'),array(
                    'class'=>'form-control select-picker',
                    'data-live-search' => true,
                    'prompt' => $model->getAttributeLabel('room_color_id'),
                )); ?>
                <?php echo $form->error($model,'room_color_id'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'body_type_id', Lists::getList('body_types'),array(
                    'class'=>'form-control select-picker',
                    'prompt' => $model->getAttributeLabel('body_type_id'),
                )); ?>
                <?php echo $form->error($model,'body_type_id'); ?>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-nowrap">
                <?php echo $form->radioButtonList($model,'plate_type_id', Lists::getList('plate_types'),array(
                    'class'=>'form-control select-picker',
                    'separator'=> '',
                    'template'=> '<div class="radio">{input} {label}</div>',
                    'prompt' => $model->getAttributeLabel('plate_type_id'),
                )); ?>
                <?php echo $form->error($model,'plate_type_id'); ?>
            </div>
            <!--Millage-->
            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <?php echo $form->radioButtonList($model,'car_type_id', Lists::getList('car_types'),array(
                    'class'=>'form-control select-picker millage',
                    'separator'=> '',
                    'template'=> '<div class="radio">{input} {label}</div>',
                    'prompt' => $model->getAttributeLabel('car_type_id'),
                )); ?>
                <?php echo $form->error($model,'car_type_id'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="input-group">
                    <?php echo $form->textField($model,'distance', array(
                        'class'=>'form-control digitFormat',
                        'placeholder'=>$model->getAttributeLabel('distance'),
                    )); ?>
                    <span class="input-group-addon">کیلومتر</span>
                </div>
                <?php echo $form->error($model,'distance'); ?>
            </div>
            <div class="clearfix"></div>
            <!--Purchase-->
            <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <?php echo $form->radioButtonList($model,'purchase_type_id', $model->purchase_types,array(
                    'class'=>'form-control select-picker purchase_type',
                    'separator'=> '',
                    'template'=> '<div class="radio">{input} {label}</div>',
                    'prompt' => $model->getAttributeLabel('purchase_type_id'),
                )); ?>
                <?php echo $form->error($model,'purchase_type_id'); ?>
            </div>
            <div class="row col-lg-10 col-md-10 col-sm-10 col-xs-12">
                <div id="cash-type" <?php if($model->purchase_type_id != Cars::PURCHASE_TYPE_CASH) echo 'style="display:none"'?>>
                    <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">
                        <div class="input-group white-bg">
                            <?php echo CHtml::textField('Cars[purchase_details][price]',
                                $model->getPrice(false,null),
                                array(
                                    'class'=>'form-control digitFormat',
                                    'maxLength' => 12,
                                    'placeholder'=>'قیمت',
                                )); ?>
                            <span class="input-group-addon">تومان</span>
                        </div>
                    </div>
                </div>
                <div id="instalment-type" <?php if($model->purchase_type_id != Cars::PURCHASE_TYPE_INSTALMENT) echo 'style="display:none"'?>>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group white-bg">
                            <?php echo CHtml::textField('Cars[purchase_details][totalPrice]',
                                $model->getPurchaseDetail('totalPrice'),
                                array(
                                    'class'=>'form-control digitFormat',
                                    'maxLength' => 12,
                                    'placeholder'=>'قیمت نهایی',
                                )); ?>
                            <span class="input-group-addon">تومان</span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group white-bg">
                            <?php echo CHtml::textField('Cars[purchase_details][downPayment]',
                                $model->getPurchaseDetail('downPayment'),
                                array(
                                    'class'=>'form-control digitFormat',
                                    'maxLength' => 12,
                                    'placeholder'=>'پیش پرداخت',
                                )); ?>
                            <span class="input-group-addon">تومان</span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group white-bg">
                            <?php echo CHtml::textField('Cars[purchase_details][downPaymentSecondary]',
                                $model->getPurchaseDetail('downPaymentSecondary'),
                                array(
                                    'class'=>'form-control digitFormat',
                                    'maxLength' => 12,
                                    'placeholder'=>'پیش پرداخت دوم',
                                )); ?>
                            <span class="input-group-addon">تومان</span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group white-bg">
                            <?php echo CHtml::textField('Cars[purchase_details][monthlyPayment]',
                                $model->getPurchaseDetail('monthlyPayment'),
                                array(
                                    'class'=>'form-control digitFormat',
                                    'maxLength' => 12,
                                    'placeholder'=>'مبلغ هر قسط',
                                )); ?>
                            <span class="input-group-addon">تومان</span>
                        </div>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?php echo CHtml::dropDownList('Cars[purchase_details][numberOfInstallment]',
                            $model->getPurchaseDetail('numberOfInstallment'),
                            $model->numberOfInstallments,
                            array(
                                'class'=>'form-control select-picker',
                                'prompt'=>'تعداد اقساط',
                            )); ?>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?php echo CHtml::dropDownList('Cars[purchase_details][numberOfMonth]',
                            $model->getPurchaseDetail('numberOfMonth'),
                            $model->numberOfMonth,
                            array(
                                'class'=>'form-control select-picker numberOfMonth',
                                'prompt'=>'موعد پرداخت',
                            )); ?>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <?php echo CHtml::dropDownList('Cars[purchase_details][deliveryInDays]',
                            $model->getPurchaseDetail('deliveryInDays'),
                            $model->deliveryInDays,
                            array(
                                'class'=>'form-control select-picker deliveryInDays',
                                'prompt'=>'موعد تحویل',
                            )); ?>
                    </div>
                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12 fade">
                        <div class="input-group white-bg">
                            <?php echo CHtml::textField('Cars[purchase_details][deliveryInFewDays]',
                                $model->getPurchaseDetail('deliveryInFewDays'),
                                array(
                                    'class'=>'form-control digitFormat',
                                    'maxLength' => 3,
                                    'placeholder'=>'زمان تحویل دلخواه',
                            )); ?>
                            <span class="input-group-addon">روز</span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <?php echo $form->error($model,'purchase_details'); ?>
            </div>
            <!--****************************************************-->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"><hr></div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'state_id', Towns::model()->getTowns(),array(
                    'class'=>'form-control select-picker load-list',
                    'data-live-search' => true,
                    'data-url'=>$this->createUrl('/car/public/getStateCities'),
                    'data-target' => '#Cars_city_id',
                    'prompt' => $model->getAttributeLabel('state_id'),
                )); ?>
                <?php echo $form->error($model,'state_id'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'city_id', $model->state_id?Places::getCities($model->state_id):[],array(
                    'class'=>'form-control select-picker',
                    'data-live-search' => true,
                    'disabled'=>$model->state_id?false:'disabled',
                    'prompt' => $model->getAttributeLabel('city_id'),
                )); ?>
                <?php echo $form->error($model,'city_id'); ?>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->textField($model,'visit_district', array(
                    'class'=>'form-control',
                    'placeholder' => $model->getAttributeLabel('visit_district'),
                )); ?>
                <?php echo $form->error($model,'visit_district'); ?>
            </div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php echo $form->textArea($model,'description', array(
                    'class'=>'form-control',
                    'placeholder' => $model->getAttributeLabel('description'),
                    'rows'=>5,
                )); ?>
                <?php echo $form->error($model,'description'); ?>
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
        var id = $(this).val();
        target.attr('disabled', 'disabled');
        $.ajax({
            url: url,
            type: 'GET',
            data:{id: id},
            dataType: 'json',
            success: function(data){
                if(data.status){
                    target.find('option:not(:first-of-type)').remove();
                    for (var i = 0; i < data.list.length; i++) {
                      target.append($('<option>', {
                        value: data.list[i].id,
                        text: data.list[i].title
                      }));
                    }
                    target.attr('disabled', false); 
                    target.selectpicker('refresh');
                }else
                    alert(data.message);
            }
        });
    }).on('change', '.deliveryInDays', function(){
        var val=$('#Cars_purchase_details_deliveryInDays').val();
        console.log(val == -1);
        var target=$('#Cars_purchase_details_deliveryInFewDays');
        if(val == -1)
            target.val('').parents('.form-group').addClass('in');
        else
            target.val('').parents('.form-group').removeClass('in');
    }).on('change', '.millage', function(){
        var label=$(this).parent().find('label').text();
        var target=$('#Cars_distance');
        if(label == 'کارکرده')
            target.val('').attr('disabled',false);
        else
            target.val('0').attr('disabled','disabled');
    }).on('change', '.purchase_type', function(){
        var val=$(this).val();
        var cash=$('#cash-type');
        var instalment=$('#instalment-type');
        if(val == 0){
            instalment.hide();
            cash.show();
        }else if(val == 1){
            instalment.show();
            cash.hide();
        }
        else if(val == 2){
            instalment.hide();
            cash.hide();
        }
    });
    
    var label=$('.millage:checked').parent().find('label').text();
    var target=$('#Cars_distance');
    if(label == 'کارکرده')
        target.attr('disabled',false);
    else
        target.val('0').attr('disabled','disabled');
");
