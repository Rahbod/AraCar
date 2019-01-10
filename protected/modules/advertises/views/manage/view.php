<?php
/* @var $this AdvertisesManageController */
/* @var $model Advertises */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->title,
);

$this->menu=array(
	array('label'=>'لیست تبلیغ', 'url'=>array('index')),
	array('label'=>'افزودن تبلیغ', 'url'=>array('create')),
	array('label'=>'ویرایش تبلیغ', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف تبلیغ', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت تبلیغ', 'url'=>array('admin')),
);
?>

<h1>نمایش تبلیغ #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'banner',
		'link',
		'placement',
		'create_date',
		'expire_date',
		'status',
	),
)); ?>
