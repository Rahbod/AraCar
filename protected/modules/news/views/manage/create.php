<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $image [] */

$this->breadcrumbs=array(
	'مدیریت اخبار'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت اخبار', 'url'=>array('admin')),
);
?>
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">افزودن خبر</h3>
		<a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
			<span class="hidden-xs">بازگشت</span>
			<i class="fa fa-arrow-left"></i>
		</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>
	</div>
</div>