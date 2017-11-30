<?php
/* @var $this CarManageController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'مدیریت آگهی ها',
);

$this->menu=array(
	array('label'=>'افزودن اگهی', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت آگهی های ماشین</h3>
        <a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن آگهی جدید</a>
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//layouts/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'cars-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped table-hover',
                'template' => '{items} {pager}',
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
                    'brand_id',
                    'model_id',
                    'state_id',
                    'city_id',
                    'status',
                    'create_date',
                    'update_date',
                    'expire_date',
                    array(
                        'class'=>'CButtonColumn',
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>