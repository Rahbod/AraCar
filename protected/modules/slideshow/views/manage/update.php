<?php
/* @var $this SlideShowManageController */
/* @var $model Slideshow */
/* @var $image array */

$this->breadcrumbs=array(
	'مدیریت'=>array('admin'),
	'ویرایش',
);

$this->menu=array(
	array('label'=>'مدیریت تصاویر', 'url'=>array('admin')),
);

?>

<h1>ویرایش تصویر "<?php echo $model->title; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model,
	'image' => $image)); ?>