<?php
/* @var $this AdvertisesManageController */
/* @var $model Advertises */

$this->breadcrumbs=array(
	'مدیریت',
);

$this->menu=array(
	array('label'=>'افزودن تبلیغ', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت تبلیغات</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن تبلیغ</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'advertises-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped',
                'template' => '{summary} {pager} {items} {pager}',
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
                    'title',
//                    'banner',
//                    'link',
                    [
                        'name' => 'placement',
                        'filter' => $model->getPlacementLabels(),
                        'value' => '$data->placementLabel'
                    ],
                    [
                        'name' => 'status',
                        'filter' => $model->statusLabels,
                        'value' => '$data->statusLabel'
                    ],
                    [
                        'name' => 'type',
                        'filter' => $model->typeLabels,
                        'value' => '$data->typeLabel'
                    ],
//                    'create_date',
                    /*
                    'expire_date',
                    'status',
                    */
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{update} {delete}'
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>