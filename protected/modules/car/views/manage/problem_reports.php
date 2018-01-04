<?php
/* @var $this CarManageController */
/* @var $model Cars */
/* @var $data Reports */

$this->breadcrumbs=array(
	'گزارش اشکالات',
);
?>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">گزارش اشکالات</h3>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'reports-grid',
				'dataProvider'=>$model->search(false, true),
				'filter'=>$model,
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
					array(
						'header' => 'آگهی',
						'value' => function($data){
							/* @var $data Reports */
                            return CHtml::link($data->car->getTitle(false), $data->car->getViewUrl(), array('target' => '_blank'));
                        },
						'filter' => CHtml::activeDropDownList($model,'car_id', CHtml::listData(Cars::model()->findAll(),'id','rawTitle'),array('prompt' => 'آگهی مورد نظر را انتخاب کنید')),
                        'type' => 'raw'
					),
					'reason',
					'description:html',
					[
						'name' => 'car.status',
						'value' => function($data){
							$class = '';
							$data = $data->car;
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
						'header'=>'تغییر وضعیت آگهی',
						'value'=>'CHtml::activeDropDownList($data->car, "status", $data->car->getStatusLabels(false), array("class"=>"change-status", "data-id"=>$data->car_id))',
						'type'=>'raw'
					],
					array(
						'class'=>'CButtonColumn',
						'template' => '{delete}',
						'deleteConfirmation' => 'آیا از حذف این گزارش اطمینان دارید؟',
						'buttons' => array(
							'delete' => array(
								'url' => 'Yii::app()->controller->createUrl("/car/manage/deleteReport/".$data->id)'
							)
						)
					),
				),
			)); ?>
		</div>
	</div>
</div>
<?php Yii::app()->clientScript->registerScript('changeConfirm', "
	$('body').on('change', '.change-status', function(){
        if(confirm(\"آیا از تغییر وضعیت این اپ اطمینان دارید؟\"))
        	$.ajax({
				url:'".$this->createUrl('/car/manage/changeStatus')."',
				type:'POST',
				dataType:'json',
				data: {id:$(this).data('id'), value:$(this).val()},
				success: function(data){
					if(data.status)
						$.fn.yiiGridView.update('reports-grid');
					else
						alert(data.message);
				}
			});
    });
");