<?php
/* @var $this ListsManageController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'لیست Lists', 'url'=>array('index')),
	array('label'=>'افزودن Lists', 'url'=>array('create')),
	array('label'=>'ویرایش Lists', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Lists', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Lists', 'url'=>array('admin')),
);
?>

<h1>نمایش Lists #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'title',
		'is_root',
		'editable',
		'parent_id',
		'path',
	),
)); ?>
