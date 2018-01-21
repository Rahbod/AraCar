<?php
/* @var $this NewsManageController */
/* @var $model News */

$this->breadcrumbs=array(
	'نمایش لیست اخبار'=>array('index'),
	'مدیریت',
);

$this->menu=array(
	array('label'=>'لیست اخبار', 'url'=>array('index')),
	array('label'=>'لیست دسته بندی اخبار', 'url'=>array('/news/category/admin')),
	array('label'=>'افزودن خبر', 'url'=>array('create')),
	array('label'=>'افزودن دسته بندی', 'url'=>array('/news/category/create')),
);
?>

<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">مدیریت اخبار</h3>
		<a href="<?= $this->createUrl('create') ?>" class="btn btn-default btn-sm">افزودن خبر</a>
	</div>
	<div class="box-body">
		<?php $this->renderPartial("//partial-views/_flashMessage"); ?>
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
					'title',
					array(
						'name' => 'author_id',
						'value' => function($data){
							return $data->author->name_family . ' (' . $data->author->username . ')';
						},
						'filter' => CHtml::activeDropDownList($model,'author_id',
							CHtml::listData(Admins::model()->findAll(),'id','username'),array('prompt'=>'همه'))
					),
					array(
						'name' => 'category_id',
						'value' => '$data->category->fullTitle',
						'filter' => CHtml::activeDropDownList($model,'category_id',
							CHtml::listData(NewsCategories::model()->findAll(),'id','fullTitle'),array('prompt'=>'همه'))
					),
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
					array(
						'name' => 'create_date',
						'value' => 'JalaliDate::date("Y/m/d - H:i",$data->create_date)'
					),
					array(
						'name' => 'publish_date',
						'value' => '$data->publish_date?JalaliDate::date("Y/m/d - H:i",$data->publish_date):"-"'
					),
					'seen',
					[
						'header'=>'تغییر وضعیت',
						'value'=>'CHtml::activeDropDownList($data, "status", $data->getStatusLabels(false), array("class"=>"change-status", "data-id"=>$data->id))',
						'type'=>'raw'
					],
					array(
						'class'=>'CButtonColumn',
					),
				),
			)); ?>
		</div>
	</div>
</div>

<?php Yii::app()->clientScript->registerScript('changeStatus', "
    $('body').on('change', '.change-status', function(){
    	if(confirm(\"آیا از تغییر وضعیت این خبر اطمینان دارید؟\"))
			$.ajax({
				url:'".$this->createUrl('/news/manage/changeStatus')."',
				type:'POST',
				dataType:'json',
				data: {id:$(this).data('id'), value:$(this).val()},
				success: function(data){
					if(data.status)
						$.fn.yiiGridView.update('lists-grid');
					else
						alert(data.message);
				}
			});
    });
");