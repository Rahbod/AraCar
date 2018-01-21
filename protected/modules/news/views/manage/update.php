<?php
/* @var $this NewsManageController */
/* @var $model News */
/* @var $image [] */

$this->breadcrumbs=array(
	'مدیریت اخبار'=>array('admin'),
	$model->title=>array('view','id'=>$model->id),
	'ویرایش',
);


$this->menu=array(
	array('label'=>'لیست اخبار', 'url'=>array('index')),
	array('label'=>'مدیریت اخبار', 'url'=>array('admin')),
	array('label'=>'افزودن خبر', 'url'=>array('create')),
	array('label'=>'نمایش این خبر', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">ویرایش خبر <?php echo $model->title; ?></h3>
		<a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
		   onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
		   class="btn btn-danger btn-sm">حذف خبر</a>
		<a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
			<span class="hidden-xs">بازگشت</span>
			<i class="fa fa-arrow-left"></i>
		</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial('_form', array('model'=>$model,'image' => $image)); ?>
	</div>
</div>