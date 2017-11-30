<?php
/* @var $this ListsManageController */
/* @var $model Lists */

$this->breadcrumbs=array(
	'مدیریت لیست ها',
);

$this->menu=array(
	array('label'=>'افزودن لیست جدید', 'url'=>array('create')),
);
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">مدیریت لیست ها</h3>
<!--        <a href="--><?//= $this->createUrl('create') ?><!--" class="btn btn-default btn-sm">افزودن لیست</a>-->
    </div>
    <div class="box-body">
        <?php $this->renderPartial("//layouts/_flashMessage"); ?>        
        <div class="table-responsive">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'lists-grid',
                'dataProvider'=>$model->search(),
                'filter'=>$model,
                'itemsCssClass'=>'table table-striped',
                'template' => '{pager} {items} {pager}',
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
                        'name' => 'title',
                        'htmlOptions'  =>[
                            'style' => 'width: 150px'
                        ]
                    ],
                    'description',
                    [
                        'header' => 'تعداد گزینه ها',
                        'value' => '$data->getOptions(true)?Controller::parseNumbers(number_format($data->getOptions(true)))." گزینه":"-"',
                        'htmlOptions'  =>[
                            'style' => 'width: 100px'
                        ]
                    ],
                    array(
                        'class'=>'CButtonColumn',
                        'template' => '{update} {options}',
                        'htmlOptions'  =>[
                            'style' => 'width: 150px;text-align:left'
                        ],
                        'buttons' => [
                            'update' => array(
                                'label' => '<i class="fa fa-edit"></i> ویرایش',
                                'options' => ['class' => 'btn btn-warning btn-sm'],
                                'imageUrl' => false,
                                'visible' => '$data->editable'
                            ),
                            'options' => array(
                                'label' => '<i class="fa fa-bars"></i> گزینه ها',
                                'url' => 'Yii::app()->controller->createUrl("manage/options/".$data->id)',
                                'options' => ['class' => 'btn btn-primary  btn-sm']
                            )
                        ]
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>