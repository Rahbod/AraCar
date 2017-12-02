<?php
/* @var $this SlideShowManageController */
/* @var $model Slideshow */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن تصویر', 'url'=>array('create')),
);
?>

<h1>مدیریت تصاویر</h1>
<?php $this->renderPartial('//partial-views/_flashMessage'); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'slideshow-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'image',
			'header' => 'تصویر',
			'filter' => '',
			'type' => 'html',
			'value' => 'CHtml::tag("div",
							array("style"=>"text-align: center" ) ,
							CHtml::tag("img",
								array("height"=>"50px","width"=>"50px",
									"src" => "' . Yii::app()->createAbsoluteUrl('/uploads/slideshow/$data->image') . '" ,"alt" => ""
									)
								)
							)',
		),
		'title',
		'link',
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); ?>
