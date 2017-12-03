<?php
/* @var $this CarManageController */
/* @var $model Cars */
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
				'maxFiles' => 4,
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
			<?php echo $form->error($model,'logo'); ?>
			<div class="uploader-message error"></div>
		</div>
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<p class="form-title">
			شما نیز با تکمیل فرم زیر خودرو را به صرعت بفروشید
		</p>
		<div class="row">
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'brand_id', Brands::getList(),array(
                    'class'=>'form-control select-picker load-list',
                    'data-url'=>$this->createUrl('/car/public/getBrandModels'),
                    'data-target' => '#Car_model_id',
                    'placeholder' => 'برند وسیله نقلیه'
                )); ?>
                <?php echo $form->error($model,'brand_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'model_id', [],array(
                    'class'=>'form-control select-picker load-list',
                    'data-url'=>$this->createUrl('/car/public/getModelYears'),
                    'data-target' => '#Car_year_id',
                    'disabled'=>'disabled',
                    'placeholder' => 'مدل وسیله نقلیه'
                )); ?>
                <?php echo $form->error($model,'model_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?php echo $form->dropDownList($model,'year_id', [],array(
                    'class'=>'form-control select-picker',
                    'disabled'=>'disabled',
                    'placeholder' => 'سال تولید'
                )); ?>
                <?php echo $form->error($model,'year_id'); ?>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<select class="form-control select-picker">
					<option value="0">سوخت</option>
				</select>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<select class="form-control select-picker">
					<option value="0">گیربکس</option>
				</select>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<input type="text" class="form-control" placeholder="کارکرد">
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="radio">
					<input type="radio" class="form-control" name="test">
					<label>صفر</label>
				</div>
				<div class="radio">
					<input type="radio" class="form-control" name="test">
					<label>صفر</label>
				</div>
			</div>


			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="input-group white-bg">
					<input type="text" class="form-control">
					<span class="input-group-addon">تومان</span>
				</div>
			</div>

			<div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="radio">
					<input type="radio" class="form-control" name="test">
					<label>صفر</label>
				</div>
				<div class="radio">
					<input type="radio" class="form-control" name="test">
					<label>صفر</label>
				</div>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<select class="form-control select-picker">
					<option value="0">برند وسیله نقلیه</option>
				</select>
				<div class="errorMessage">- الزامی</div>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<select class="form-control select-picker">
					<option value="0">مدل</option>
				</select>
			</div>
			<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<select class="form-control select-picker">
					<option value="0">سال</option>
				</select>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="radio">
					<input type="radio" class="form-control">
					<label>صفر</label>
				</div>
				<div class="radio">
					<input type="radio" class="form-control">
					<label>کارکرده</label>
				</div>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<textarea rows="5" class="form-control" placeholder="توضیحات"></textarea>
			</div>
			<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<button type="submit" class="btn btn-primary pull-left">ادامه</button>
			</div>
		</div>
	</div>
<?php $this->endWidget() ?>

<?php
Yii::app()->clientScript->registerScript("sell-js","
    $('body').on('change', '.load-list', function(){
        var url = $(this).data('url');
        var target = $($(this).data('target'));
        var bid = $(this).val();
        $.ajax({
            url: url,
            type: 'GET',
            data:{bid: bid},
            dataType: 'json',
            beforeSend: function(){
                target.attr('disabled', 'disabled');
            },
            success: function(data){
                target.html(data);
                target.attr('disabled', false); 
                target.selectpicker('refresh');
            }
        });
    });
");
