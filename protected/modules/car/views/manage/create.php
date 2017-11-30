<?php
/* @var $this CarManageController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'مدیریت آگهی ها'=>array('admin'),
	'افزودن',
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن Cars</h3>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model)); ?>	</div>
</div>