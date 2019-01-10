<?php
/* @var $this AdvertisesManageController */
/* @var $model Advertises */
/* @var $banner UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن تبلیغ</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model, 'banner' => $banner)); ?>
    </div>
</div>