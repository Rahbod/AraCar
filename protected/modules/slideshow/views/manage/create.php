<?php
/* @var $this SlideShowManageController */
/* @var $model Slideshow */
/* @var $image array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'افزودن',
);

$this->menu=array(
	array('label'=>'مدیریت تصاویر', 'url'=>array('admin')),
);
?>

<h1>افزودن تصویر</h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
	'image'=>$image,
)); ?>