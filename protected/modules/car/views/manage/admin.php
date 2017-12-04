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
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
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
            		'title:html',
                    [
                        'name' => 'state_id',
                        'value' => '$data->state->name'
                    ],
                    [
                        'name' => 'city_id',
                        'value' => '$data->city->name'
                    ],
                    [
                        'name' => 'status',
                        'value' => function($data){
                            $class = '';
                            if($data->status == Cars::STATUS_DELETED)
                                $class = 'danger';
                            else if($data->status == Cars::STATUS_APPROVED)
                                $class = 'success';
                            else if($data->status == Cars::STATUS_PENDING)
                                $class = 'info';
                            else if($data->status == Cars::STATUS_REFUSED)
                                $class = 'warning';
                            return "<div class='label label-{$class}'>{$data->statusLabel}</div>";
                        },
                        'type' => 'raw'
                    ],
                    [
                        'name' => 'create_date',
                        'value' => 'JalaliDate::date("Y/m/d",$data->create_date)'
                    ],
                    [
                        'name' => 'create_date',
                        'value' => 'JalaliDate::date("Y/m/d",$data->create_date)'
                    ],
                    [
                        'name' => 'update_date',
                        'value' => '$data->update_date?JalaliDate::date("Y/m/d",$data->update_date):"-"'
                    ],
                    [
                        'name' => 'expire_date',
                        'value' => '$data->expire_date?JalaliDate::date("Y/m/d",$data->expire_date):"-"'
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'buttons' => array(
                            'view' => array(
                                'url' => '$data->getViewUrl()'
                            )
                        )
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>