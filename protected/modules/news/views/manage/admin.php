<?php
/* @var $this NewsManageController */
/* @var $model News */

$this->breadcrumbs=array(
	'نمایش لیست اخبار'=>array('index'),
	'مدیریت',
);

$this->menu=array(
	array('label'=>'لیست اخبار', 'url'=>array('index')),
	array('label'=>'لیست دسته بندی اخبار', 'url'=>array('/news/category/admin')),
	array('label'=>'افزودن خبر', 'url'=>array('create')),
	array('label'=>'افزودن دسته بندی', 'url'=>array('/news/category/create')),
);
?>

<h1>مدیریت اخبار</h1>
<? $this->renderPartial('//partial-views/_flashMessage'); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
//<?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
//	'orderField' => 'order',
//	'idField' => 'id',
//	'orderUrl' => 'order',
	'id'=>'news-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		array(
			'name' => 'author_id',
			'value' => function($data){
				return $data->author->name_family . ' (' . $data->author->username . ')';
			},
			'filter' => CHtml::activeDropDownList($model,'category_id',
				CHtml::listData(NewsCategories::model()->findAll(),'id','fullTitle'),array('prompt'=>'همه'))
		),
		array(
			'name' => 'category_id',
			'value' => '$data->category->fullTitle',
			'filter' => CHtml::activeDropDownList($model,'category_id',
				CHtml::listData(NewsCategories::model()->findAll(),'id','fullTitle'),array('prompt'=>'همه'))
		),
		array(
			'name' => 'status',
			'value' => '$data->statusLabel'
		),
		array(
			'name' => 'create_date',
			'value' => 'JalaliDate::date("Y/m/d - H:i",$data->create_date)'
		),
		array(
			'name' => 'publish_date',
			'value' => '$data->publish_date?JalaliDate::date("Y/m/d - H:i",$data->publish_date):"-"'
		),
		'seen',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
