<?php
/* @var $this CarBrandsController */
/* @var $model Models */
/* @var $details ModelDetails */
/* @var $image UploadedFiles */

$this->breadcrumbs=array(
	'مدیریت برند ها'=>array('admin'),
	'مدیریت مدل های '.$model->brand->title=>array('brands/models/'.$model->brand_id),
	$model->title,
	'ویرایش',
);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">ویرایش مدل <?php echo $model->title; ?></h3>
        <a href="<?= $this->createUrl('modelDelete').'/'.$model->id; ?>"
           onclick="if(!confirm('آیا از حذف این مورد اطمینان دارید؟')) return false;"
           class="btn btn-danger btn-sm">
            <i class="fa fa-remove"></i>
            <span class="hidden-xs">حذف مدل</span>
        </a>
        <a href="<?= $this->createUrl('brands/models/'.$model->brand_id) ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial('_model_form', array(
            'model'=>$model
        )); ?>
    </div>
    <div class="box-footer">
        <h4>تعریف سال های تولید این مدل</h4>
        <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#create-model-detail">
            <i class="fa fa-"></i>
            <span class="hidden-xs">افزودن سال تولید</span>
        </a>
        <?php $this->renderPartial('_model_details_list', array(
            'model' => $details
        )); ?>
    </div>
</div>

<div class="modal fade" id="create-model-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>
                    افزودن سال تولید جدید
                    <button class="close pull-left" data-dismiss="modal">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_model_details_form',array(
                    'model' => new ModelDetails(),
                    'model_id' => $model->id
                )) ?>
            </div>
        </div>
    </div>
</div>