<?php
/* @var $this CarBrandsController */
/* @var $model ModelDetails */
/* @var $images UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت برند ها'=>array('admin'),
	'مدیریت مدل های '.$model->model->brand->title=>array('brands/models/'.$model->model->brand_id),
	'مدل '.$model->model->title =>array('brands/modelEdit/'.$model->model_id),
	$model->product_year,
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش سال تولید <?php echo $model->product_year; ?></h3>
        <a href="<?= $this->createUrl('modelDetailDelete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این سال تولید اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">
            <i class="fa fa-remove"></i>
            <span class="hidden-xs">حذف سال تولید</span>
        </a>
        <a href="<?= $this->createUrl('brands/modelEdit/'.$model->model->id) ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_model_details_form',array(
            'model' => $model,
            'images' => $images
        )) ?>
    </div>
</div>