<?php
/* @var $this ListsManageController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت لیست ها'=>array('admin'),
	$model->name=>array('view','id'=>$model->title),
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش لیست <?php echo $model->title; ?></h3>
        <a href="<?= $this->createUrl('delete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">حذف لیست</a>
        <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_form', array('model'=>$model)); ?>
    </div>
</div>
