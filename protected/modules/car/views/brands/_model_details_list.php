<?php
/* @var $this CarBrandsController */
/* @var $model ModelDetails */
?>
<div class="table-responsive">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'details-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
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
            'product_year',
            array(
                'class'=>'CButtonColumn',
                'template' => '{update} {delete}',
                'buttons' => array(
                    'update' => array('url' => 'Yii::app()->createUrl("/car/brands/modelDetailEdit/".$data->id)'),
                    'delete' => array('url' => 'Yii::app()->createUrl("/car/brands/modelDetailDelete/".$data->id)')
                )
            ),
        ),
    )); ?>
</div>