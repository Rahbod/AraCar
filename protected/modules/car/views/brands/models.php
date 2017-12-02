<?php
/* @var $this CarBrandsController */
/* @var $model Brands */
/* @var $modelsSearch Models */

$this->breadcrumbs=array(
    'مدیریت برندها' => array('admin'),
	'مدیریت مدل های '. $model->title,
);

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت مدل های <?= $model->title ?></h3>
        <a href="#" data-toggle="modal" data-target="#create-modal" class="btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            <i class="fa fa-car"></i>
            <span class="hidden-xs">افزودن مدل جدید</span>
        </a>
        <a href="<?= $this->createUrl('admin') ?>" class="btn btn-primary btn-sm pull-left">
            <span class="hidden-xs">بازگشت</span>
            <i class="fa fa-arrow-left"></i>
        </a>
    </div>
    <div class="box-body">
        <p>
            <i class="fa fa-info-circle"></i>
            مدل های برند <b class="text-primary"><?= $model->title ?></b> را تعریف کنید.
        </p>
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('ext.yiiSortableModel.widgets.SortableCGridView', array(
                'orderField' => 'order',
                'idField' => 'id',
	            'orderUrl' => 'order',
                'jqueryUiSortableOptions' => array('handle' => '.sortable-handle'),
                'id'=>'brands-grid',
                'dataProvider'=>$modelsSearch->search(),
                'filter'=>$modelsSearch,
                'itemsCssClass'=>'table table-striped table-hover',
                'template' => '{summary} {items} {pager}',
                'ajaxUpdate' => true,
                'afterAjaxUpdate' => "function(id, data){
                    $('html, body').animate({
                        scrollTop: ($('#'+id).offset().top-130)
                    },1000,'easeOutCubic');
                }",
                'pager' => array(
                    'header' => '',
                    'firstPageLabel' => '<<',
                    'lastPageLabel' => '>>',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'cssFile' => false,
                    'htmlOptions' => array(
                        'class' => 'pagination pagination-sm',
                    ),
                ),
                'pagerCssClass' => 'blank',
                'columns'=>array(
                    [
                        'class'=>'SortableGridColumn',
                    ],
                    'title',
                    'slug',
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{update} {delete}',
                        'buttons' => array(
                            'update' => array(
                                'url' => 'Yii::app()->createUrl("/car/brands/modelEdit/".$data->id)',
                            ),
                            'delete' => array(
                                'url' => 'Yii::app()->createUrl("/car/brands/modelDelete/".$data->id)'
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="create-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>
                    افزودن مدل جدید
                    <button class="close pull-left" data-dismiss="modal">&times;</button>
                </h3>
            </div>
            <div class="modal-body">
                <?php $this->renderPartial('_model_form',array(
                    'model' => new Models(),
                    'brand_id' => $model->id
                )) ?>
            </div>
        </div>
    </div>
</div>