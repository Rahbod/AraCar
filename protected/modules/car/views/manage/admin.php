<?php
/* @var $this CarManageController */
/* @var $model Cars */

$this->breadcrumbs=array(
	'پیشخوان' => array('/admins/dashboard'),
	'مدیریت آگهی ها',
);

$this->menu=array(
	array('label'=>'افزودن اگهی', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت آگهی های ماشین</h3>
        <a href="<?= $this->createUrl('recycleBin') ?>" class="btn btn-warning btn-sm pull-left">
            <span class="hidden-xs">زباله دان</span>
            <i class="fa fa-trash"></i>
        </a>
<!--        <a href="--><?//= $this->createUrl('create') ?><!--" class="btn btn-default btn-sm">افزودن آگهی جدید</a>-->
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//partial-views/_flashMessage"); ?>
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'cars-grid',
                'dataProvider'=>$model->search(false, true),
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
                        'name' => 'update_date',
                        'value' => '$data->update_date?JalaliDate::date("Y/m/d",$data->update_date):"-"'
                    ],
                    [
                        'name' => 'expire_date',
                        'value' => '$data->expire_date?JalaliDate::date("Y/m/d",$data->expire_date):"-"'
                    ],
                    [
                        'header'=>'تغییر وضعیت',
                        'value'=>'CHtml::activeDropDownList($data, "status", $data->getStatusLabels(false), array("class"=>"change-status", "data-id"=>$data->id))',
                        'type'=>'raw'
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{view} {delete}',
                        'deleteConfirmation' => 'آیا از انتقال آگهی به زباله دان اطمینان دارید؟',
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
<?php Yii::app()->clientScript->registerScript('changeStatus', "
    $('body').on('change', '.change-status', function(){
        $.ajax({
            url:'".$this->createUrl('/car/manage/changeStatus')."',
            type:'POST',
            dataType:'json',
            data: {id:$(this).data('id'), value:$(this).val()},
            success: function(data){
                if(data.status)
                    $.fn.yiiGridView.update('cars-grid');
                else
                    alert(data.message);
            }
        });
    });
");