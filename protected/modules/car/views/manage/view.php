<?php
/* @var $this CarManageController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'لیست Cars', 'url'=>array('index')),
	array('label'=>'افزودن Cars', 'url'=>array('create')),
	array('label'=>'ویرایش Cars', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'حذف Cars', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'مدیریت Cars', 'url'=>array('admin')),
);
?>

<h1>نمایش Cars #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'create_date',
		'update_date',
		'expire_date',
		'user_id',
		'brand_id',
		'model_id',
		'room_color_id',
		'body_color_id',
		'body_state_id',
		'state_id',
		'city_id',
		'fuel_id',
		'gearbox_id',
		'car_type_id',
		'plate_type_id',
		'purchase_type_id',
		'purchase_details',
		'distance',
		'status',
		'visit_district',
		'description',
	),
)); ?>
